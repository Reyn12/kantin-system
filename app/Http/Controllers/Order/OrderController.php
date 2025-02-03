<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function setTable(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|regex:/^[A-Z][0-9]+$/' // Format: Huruf kapital diikuti angka (A1, B2, dll)

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
        $order = []; // Nanti ambil dari database berdasarkan table_number

        return view('order.status', compact('order'));
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