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
        $unpaidOrders = Order::where('kasir_id', null)
            ->where('status', 'menunggu_pembayaran')
            ->get();

        return view('kasir.dashboard.dashboard', compact('unpaidOrders'));
    }
}