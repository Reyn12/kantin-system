<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:products,id',  
            'quantity' => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        
        // Add item to cart
        $cart[$request->menu_id] = [
            'quantity' => ($cart[$request->menu_id]['quantity'] ?? 0) + $request->quantity,
            'note' => $request->note
        ];

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan ke keranjang!'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0',
            'note' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);

        if ($request->quantity == 0) {
            unset($cart[$request->menu_id]);
        } else {
            $cart[$request->menu_id] = [
                'quantity' => $request->quantity,
                'note' => $request->note
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!'
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:products,id' 
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->menu_id]);
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus dari keranjang!'
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong!'
            ], 400);
        }

        // Proses checkout
        // 1. Create order
        // 2. Create order items
        // 3. Clear cart
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'redirect' => route('order.status')
        ]);
    }
}