<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mengambil semua data order');
            $orders = Order::with(['customer', 'kasir', 'orderItems.product'])->latest()->get();
            
            return view('admin.orders.order', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data order: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data order');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'kasir_id' => 'required|exists:users,id',
                'nomor_meja' => 'required|string',
                'catatan' => 'nullable|string',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.jumlah' => 'required|integer|min:1'
            ]);

            $totalHarga = 0;
            $orderItems = [];

            // Hitung total harga dan prepare order items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $hargaSatuan = $product->harga;
                $subtotal = $hargaSatuan * $item['jumlah'];
                $totalHarga += $subtotal;

                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal
                ];
            }

            // Create order
            $order = Order::create([
                'user_id' => $request->user_id,
                'kasir_id' => $request->kasir_id,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'nomor_meja' => $request->nomor_meja,
                'catatan' => $request->catatan
            ]);

            // Create order items
            $order->orderItems()->createMany($orderItems);

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order' => $order->load('orderItems.product')
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat membuat order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat order'
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::with(['customer', 'kasir', 'orderItems.product'])->findOrFail($id);
            return response()->json($order);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Order tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:menunggu_pembayaran,dibayar,diproses,selesai,dibatalkan'
            ]);

            $order = Order::findOrFail($id);
            $order->update([
                'status' => $request->status
            ]);

            return response()->json([
                'message' => 'Status order berhasil diupdate'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat update order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat update order'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json([
                'message' => 'Order berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat hapus order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat hapus order'
            ], 500);
        }
    }
}