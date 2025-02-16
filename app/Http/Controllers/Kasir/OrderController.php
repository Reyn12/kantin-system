<?php
// Kasir OrderController.php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Finller\Invoice\Invoice;
use Finller\Invoice\InvoiceItem;
use Finller\Invoice\InvoiceState;
use Finller\Invoice\InvoiceType;
use Brick\Money\Money;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->table_number;

        if ($tableNumber) {
            // Cari order berdasarkan nomor meja dan mencari menggunakan LIKE
            $orders = Order::where('nomor_meja', 'like', '%' . $tableNumber . '%')->get();
        } else {
            $orders = Order::where('kasir_id', Auth::user()->id)->get();
        }

        // Filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            if (!$start_date) {
                $start_date = date('Y-m-d');
            }
            
            if (!$end_date) {
                $end_date = date('Y-m-d');
            }

            if ($start_date > $end_date) {
                return redirect()->back()->with('error', 'Tanggal awal harus lebih kecil dari tanggal akhir.');
            }

            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $orders = $orders->filter(function ($order) use ($start_date, $end_date) {
                return $order->created_at >= $start_date && $order->created_at <= $end_date;
            });
        }
        
        return view('kasir.orders.order', compact('orders'));
    }

    public function edit($id) {
        try {
            $order = Order::with(['customer', 'kasir', 'orderItems.product'])->findOrFail($id);
            // if ($order->kasir_id && $order->kasir_id !== auth()->user()->id) {
            //     return response()->json([
            //         'message' => 'Order tidak dapat diedit oleh kasir lain'
            //     ], 403);
            // }
            return response()->json($order);
        } catch (\Exception $e) {
            // Log::error('Error saat mengambil data order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Order tidak ditemukan'
            ], 404);
        }
    }


    public function update(Request $request, $id) {
        try {
            // Kalo dari dashboard, status nya otomatis diproses
            if (!$request->has('status')) {
                $request->merge(['status' => 'diproses']);
            }

            $request->validate([
                'status' => 'required|in:menunggu_pembayaran,dibayar,diproses,selesai,dibatalkan'
            ]);

            $order = Order::findOrFail($id);
            if ($order->kasir_id && $order->kasir_id !== Auth::user()->id) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'message' => 'Order tidak dapat diedit oleh kasir lain'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Order tidak dapat diedit oleh kasir lain');
            }

            $invoice = Invoice::where('invoiceable_id', $order->id)->first();

            if ($request->status === 'dibayar' && $order->status === 'dibayar') {
                if ($request->wantsJson()) {
                    return response()->json([
                        'message' => 'Order sudah dibayar',
                    ], 400);
                }
                return redirect()->back()->with('error', 'Order sudah dibayar');
            }

            // Set kasir_id ketika status berubah jadi diproses atau dibayar
            if (in_array($request->status, ['diproses', 'dibayar'])) {
                $order->kasir_id = Auth::user()->id;
            }

            if ($request->status === 'dibayar') {
                if (!$invoice) {
                    $invoice = new Invoice([
                        'type' => InvoiceType::Invoice,
                        'state' => InvoiceState::Paid,
                        'description' => 'Invoice Meja ' . $order->nomor_meja . ' untuk ' . $order->customer->name . ' pada ' . $order->created_at->format('d F Y'),
                        'buyer_information' => [
                            'name' => $order->customer->name,
                            'address' => null,
                            'email' => $order->customer->email,
                        ],
                        'seller_information' => [
                            'name' => Auth::user()->name,
                            'address' => null,
                            'email' => Auth::user()->email,
                        ],
                        'created_at' => $order->created_at,
                    ]);

                    $invoice->buyer()->associate($order->customer);
                    $invoice->invoiceable()->associate($order);

                    $invoice->items()->saveMany(
                        $order->orderItems->map(function ($orderItem) {
                            return new InvoiceItem([
                                'label' => $orderItem->product->nama_produk,
                                'unit_price' => Money::of($orderItem->product->harga, 'IDR'),
                                'quantity' => $orderItem->subtotal,
                                'description' => $orderItem->product->deskripsi,
                                'currency' => 'IDR',
                            ]);
                    }));

                    $invoice->save();
                }

                $invoice->state = InvoiceState::Paid;
            }

            if ($request->status === 'dibatalkan' && $invoice) {
                $invoice->state = InvoiceState::Refunded;
                $invoice->save();
            }

            $order->status = $request->status;
            $order->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Status order berhasil diperbarui'
                ]);
            }
            return redirect()->back()->with('success', 'Status order berhasil diperbarui');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat memperbarui status order: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status order: ' . $e->getMessage());
        }
    }

    public function invoice($id)
    {
        $order = Order::with(['customer', 'kasir', 'orderItems.product'])->findOrFail($id);
        
        // Tambah logging
        Log::info('Order data:', [
            'order_id' => $order->id,
            'items' => $order->orderItems->map(function($item) {
                return [
                    'product' => $item->product->nama_produk,
                    'quantity' => $item->jumlah,
                    'price' => $item->harga_satuan,
                    'total' => $item->subtotal
                ];
            }),
            'total' => $order->orderItems->sum('subtotal')
        ]);
        
        $pdf = PDF::loadView('kasir.orders.invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}