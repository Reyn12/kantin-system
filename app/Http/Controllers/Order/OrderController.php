<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function setTable(Request $request)
    {
        $request->validate([
            'table_number' => 'required|numeric|min:1'
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
        $categories = \App\Models\Category::all();
        $products = \App\Models\Product::with('category')->get();

        return view('order.menu', compact('categories', 'products'));
    }

    public function status()
    {
        $order = []; // Nanti ambil dari database berdasarkan table_number

        return view('order.status', compact('order'));
    }
}