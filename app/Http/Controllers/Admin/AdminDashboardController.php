<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats Card Data
        $pendapatanHariIni = Order::whereDate('created_at', Carbon::today())
            ->where('status', '!=', 'dibatalkan')
            ->sum('total_harga');

        $pendapatanKemarin = Order::whereDate('created_at', Carbon::yesterday())
            ->where('status', '!=', 'dibatalkan')
            ->sum('total_harga');

        $persentasePendapatan = $pendapatanKemarin > 0 
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100)
            : 0;

        $pesananHariIni = Order::whereDate('created_at', Carbon::today())->count();
        $pesananKemarin = Order::whereDate('created_at', Carbon::yesterday())->count();
        
        $persentasePesanan = $pesananKemarin > 0
            ? round((($pesananHariIni - $pesananKemarin) / $pesananKemarin) * 100)
            : 0;

        $menuTerlaris = OrderItem::select('product_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('product')
            ->whereHas('order', function($query) {
                $query->where('status', '!=', 'dibatalkan');
            })
            ->groupBy('product_id')
            ->orderBy('total_terjual', 'desc')
            ->first();

        // Grafik Penjualan Data
        $periode = request('periode', 7); // default 7 hari
        
        // Data penjualan untuk periode yang dipilih
        $penjualanPeriode = Order::where('status', '!=', 'dibatalkan')
            ->where('created_at', '>=', now()->subDays($periode))
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_harga) as total_penjualan'),
                DB::raw('COUNT(*) as jumlah_order')
            ]);

        // Data penjualan untuk periode sebelumnya (untuk perbandingan)
        $penjualanSebelumnya = Order::where('status', '!=', 'dibatalkan')
            ->where('created_at', '>=', now()->subDays($periode * 2))
            ->where('created_at', '<', now()->subDays($periode))
            ->sum('total_harga');

        // Hitung persentase perubahan
        $totalPenjualanPeriode = $penjualanPeriode->sum('total_penjualan');
        $persentasePerubahan = $penjualanSebelumnya > 0
            ? round((($totalPenjualanPeriode - $penjualanSebelumnya) / $penjualanSebelumnya) * 100, 1)
            : 0;

        // Format data untuk grafik
        $labels = $penjualanPeriode->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        $data = $penjualanPeriode->pluck('total_penjualan');

        // Transaksi Data
        $transaksi = Order::with(['customer', 'orderItems.product', 'kasir'])
            ->whereNotNull('total_harga')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($order) {
                $mainProduct = $order->orderItems->first();
                $otherProducts = $order->orderItems->count() - 1;
                
                $statusMap = [
                    'pending' => 'menunggu_pembayaran',
                    'paid' => 'dibayar',
                    'processing' => 'diproses',
                    'completed' => 'selesai',
                    'cancelled' => 'dibatalkan'
                ];

                return [
                    'id' => str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'nama_produk' => $mainProduct ? 
                        $mainProduct->product->nama_produk . ($otherProducts > 0 ? " (+{$otherProducts} items)" : "") 
                        : 'Produk tidak tersedia',
                    'total' => $order->total_harga, 
                    'status' => $statusMap[$order->status] ?? $order->status,
                    'tanggal' => $order->created_at,
                    'customer' => $order->customer ? $order->customer->name : 'Customer tidak ditemukan',
                    'kasir' => $order->kasir ? $order->kasir->name : '-'
                ]; 
            });

        return view('admin.dashboard.dashboard', compact(
            'pendapatanHariIni',
            'pendapatanKemarin',
            'persentasePendapatan',
            'pesananHariIni',
            'pesananKemarin',
            'persentasePesanan',
            'menuTerlaris',
            'periode',
            'totalPenjualanPeriode',
            'persentasePerubahan',
            'labels',
            'data',
            'transaksi'
        ));
    }
}