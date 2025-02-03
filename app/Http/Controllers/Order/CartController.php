<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            'table_number' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('order.menu')->with('error', 'Keranjang kosong!');
        }

        try {
            Log::info('Checkout process started', [
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'table_number' => $request->table_number,
                'cart' => $cart
            ]);

            // Bikin user baru untuk customer
            $user = User::create([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'password' => bcrypt('customer123'), // Password default
                'role' => 'customer'
            ]);

            Log::info('User created', ['user_id' => $user->id]);

            // Hitung total
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Simpan order
            $order = Order::create([
                'user_id' => $user->id,
                'kasir_id' => null,
                'total_harga' => $total,
                'status' => 'menunggu_pembayaran',
                'nomor_meja' => $request->table_number,
                'catatan' => null,
                'waktu_pembayaran' => null
            ]);

            Log::info('Order created', ['order_id' => $order->id]);

            // Simpan detail order
            foreach($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
            }

            Log::info('Order items created');

            // Simpan data customer ke session untuk ditampilin di halaman status
            session()->put('customer_info', [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'table' => $request->table_number
            ]);

            // Clear cart session
            session()->forget('cart');

            Log::info('Checkout completed successfully');

            return redirect()->route('order.status')->with('success', 'Pesanan berhasil dikonfirmasi!');

        } catch (\Exception $e) {
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }
}