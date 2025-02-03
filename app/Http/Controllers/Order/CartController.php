<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('order.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Inisialisasi cart di session kalo belum ada
        $cart = session()->get('cart', []);
        
        // Tambah/update item
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->nama_produk,
                'price' => $product->harga,
                'quantity' => $request->quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cartCount' => count($cart)
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'table_number' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('order.menu')->with('error', 'Keranjang kosong!');
        }

        // Simpan data customer ke session
        session()->put('customer_info', [
            'name' => $request->customer_name,
            'phone' => $request->customer_phone,
            'table' => $request->table_number
        ]);

        // Redirect ke halaman konfirmasi atau status
        return redirect()->route('order.status');
    }
}