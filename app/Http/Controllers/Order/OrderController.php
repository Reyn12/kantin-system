<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

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
            'all_data' => $request->all()
        ]);

        $request->validate([
            'table_number' => 'required|string' // Terima semua format nomor meja

        ]);

        session(['table_number' => $request->table_number]);

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
        // Ambil data cart dan customer dari session
        $cart = session()->get('cart', []);
        $customer = session()->get('customer_info');
        
        if(empty($cart) || empty($customer)) {
            return redirect()->route('order.menu')->with('error', 'Data pesanan tidak ditemukan!');
        }

        // Hitung total
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('order.status', compact('cart', 'customer', 'total'));
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

}