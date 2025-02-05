<?php
// KasihDashboardController

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class KasirDashboardController extends Controller
{
    public function index()
    {
        // Get all unpaid orders that doesnt have a kasir_id
        $unpaidOrders = Order::with(['customer', 'orderItems.product'])
            ->where('kasir_id', null)
            ->where('status', 'menunggu_pembayaran')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'nama_produk' => $order->orderItems->map(function($item) {
                        return $item->product->nama_produk;
                    })->join(', '),
                    'total' => $order->total_harga,
                    'status' => $order->status,
                    'tanggal' => $order->created_at,
                    'customer' => $order->customer ? $order->customer->name : 'Guest'
                ];
            });

        return view('kasir.dashboard.dashboard', compact('unpaidOrders'));
    }
}