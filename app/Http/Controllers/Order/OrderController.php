<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Finller\Invoice\Invoice;
use Finller\Invoice\InvoiceItem;
use Finller\Invoice\InvoiceState;
use Finller\Invoice\InvoiceType;
use Brick\Money\Money;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function setTable(Request $request)
    {
        Log::info('Table number received:', [
            'table_number' => $request->table_number,
            'input_type' => $request->input_type,
            'all_data' => $request->all()
        ]);

        $request->validate([
            'table_number' => 'required|string',
            'input_type' => 'nullable|string|in:manual,qr'
        ]);

        // Simpan data ke session
        session([
            'table_number' => $request->table_number,
            'input_type' => $request->input_type ?? 'qr' // default ke qr kalo gak ada
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nomor meja berhasil disimpan!',
            'redirect' => route('order.menu')
        ]);
    }

    public function menu()
    {
        $categories = Category::all();
        $products = Product::where('status', true)
                          ->where('stok', '>', 0)
                          ->get();

        return view('order.menu', compact('categories', 'products'));
    }

    public function status()
    {
        // Ambil order terakhir dari user
        $order = Order::with(['items.product', 'user'])
                     ->latest()
                     ->first();
        
        if (!$order) {
            return redirect()->route('order.menu')->with('error', 'Data pesanan tidak ditemukan!');
        }

        // Format data untuk view
        $customer = [
            'name' => $order->user->name,
            'phone' => $order->user->phone,
            'table' => $order->nomor_meja
        ];

        $items = [];
        foreach($order->items as $item) {
            $items[$item->product_id] = [
                'name' => $item->product->nama,
                'price' => $item->harga_satuan * 1000,
                'quantity' => $item->jumlah,
                'subtotal' => ($item->harga_satuan * 1000) * $item->jumlah
            ];
        }

        return view('order.status', [
            'customer' => $customer,
            'cart' => $items,
            'total' => $order->total_harga,
            'order' => $order
        ]);
    }

    public function getProductsByCategory($category)
    {
        $query = Product::query();
        
        if ($category !== 'all') {
            $query->where('category_id', $category);
        }
        
        $products = $query->where('status', 'tersedia')->get();
        
        // Transform products untuk handle image path
        $products = $products->map(function ($product) {
            $staticImagePath = 'images/products/' . basename($product->gambar_url);
            $product->image_url = file_exists(public_path($staticImagePath))
                ? asset($staticImagePath)
                : asset('storage/' . $product->gambar_url);
            return $product;
        });

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
        
    }

    public function resetTable()
    {
        session()->forget('table_number');
        return redirect()->route('order.index');
    }

    public function downloadInvoice(Order $order)
    {
        // Load relations
        $order->load(['items.product', 'user']);

        // Format data untuk view
        $customer = [
            'name' => $order->user->name,
            'phone' => $order->user->phone,
            'table' => $order->nomor_meja
        ];

        $items = [];
        foreach ($order->items as $item) {
            $items[$item->product_id] = [
                'name' => $item->product->nama,
                'price' => $item->harga_satuan * 1000,
                'quantity' => $item->jumlah,
                'subtotal' => ($item->harga_satuan * 1000) * $item->jumlah
            ];
        }

        $total = $order->total_harga;

        // Generate PDF using dompdf
        $pdf = PDF::loadView('order.invoice', compact('order', 'customer', 'items', 'total'));
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }

}