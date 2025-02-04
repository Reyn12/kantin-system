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


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->table_number;

        if ($tableNumber) {
            // Cari order berdasarkan nomor meja dan mencari menggunakan LIKE
            $orders = Order::where('nomor_meja', 'like', '%' . $tableNumber . '%')->get();
        } else {
            $orders = Order::where('kasir_id', auth()->user()->id)->get();
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
            $request->validate([
                'status' => 'required|in:menunggu_pembayaran,dibayar,diproses,selesai,dibatalkan'
            ]);

            $order = Order::findOrFail($id);
            if ($order->kasir_id && $order->kasir_id !== auth()->user()->id) {
                return response()->json([
                    'message' => 'Order tidak dapat diedit oleh kasir lain'
                ], 403);
            }

            $invoice = Invoice::where('invoiceable_id', $order->id)->first();

            if ($request->status === 'dibayar' && $order->status === 'dibayar') {
                return response()->json([
                    'message' => 'Order sudah dibayar',
                ], 400);
            }

            if  ($request->status === 'dibayar') {
                $order->kasir_id = auth()->user()->id;

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
                            'name' => auth()->user()->name,
                            'address' => null,
                            'email' => auth()->user()->email,
                        ],
                        'created_at' => $order->created_at,
                    ]);

                    $invoice->buyer()->associate($order->customer);
                    $invoice->invoiceable()->associate($order);

                    $invoice->items()->saveMany(
                        $order->orderItems->map(function ($orderItem) {
                            return new InvoiceItem([
                                'label' => $item->product->nama_produk,
                                'unit_price' => Money::of($item->product->harga, 'IDR'),
                                'quantity' => $item->subtotal,
                                'description' => $item->product->deskripsi,
                                'currency' => 'IDR',
                            ]);
                    }));

                    $invoice->save();
                }

                $invoice->state = InvoiceState::Paid;

            }

            if ($request->status === 'dibatalkan') {
                $invoice->state = InvoiceState::Refunded;
            }

            $order->updateStatus($request->status);
            $order->save();

            return response()->json([
                'message' => 'Status order berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saat memperbarui status order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui status order' . $e->getMessage(),
            ], 500);
        }
    }

    public function invoice($id) {
        $order = Order::with(['customer', 'kasir', 'orderItems.product'])->findOrFail($id);
        $invoiceState = null;

        if ($order->status === 'dibayar' || $order->status === 'selesai') {
            $invoiceState = InvoiceState::Paid;
        } else if ($order->status === 'dibatalkan') {
            $invoiceState = InvoiceState::Refunded;
        } else if ($order->status === 'menunggu_pembayaran') {
            $invoiceState = InvoiceState::Pending;
        } else if ($order->status === 'diproses') {
            $invoiceState = InvoiceState::Pending;
        }

        $invoice = Invoice::where('invoiceable_id', $order->id)->where('invoiceable_type', Order::class)->first();

        if ($invoice) {
            if ($invoice->state !== $invoiceState) {
                $invoice->state = $invoiceState;
                $invoice->save();
            }

            return $invoice->toPdfInvoice()->download();
        }

        $invoice = new Invoice([
            'type' => InvoiceType::Invoice,
            'state' => $invoiceState,
            'description' => 'Invoice Meja ' . $order->nomor_meja . ' untuk ' . $order->customer->name . ' pada ' . $order->created_at->format('d F Y'),
            'buyer_information' => [
                'name' => $order->customer->name,
                'address' => null,
                'email' => $order->customer->email,
            ],
            'seller_information' => [
                'name' => auth()->user()->name,
                'address' => null,
                'email' => auth()->user()->email,
            ],
            'created_at' => $order->created_at,
        ]);

        $invoice->buyer()->associate($order->customer);
        $invoice->invoiceable()->associate($order);
        $invoice->save();

        $invoice->items()->saveMany($order->items->map(function ($item) {
            return new InvoiceItem([
                'label' => $item->product->nama_produk,
                'unit_price' => Money::of($item->product->harga, 'IDR'),
                'quantity' => $item->subtotal,
                'description' => $item->product->deskripsi,
                'currency' => 'IDR',
            ]);
        }));

        return $invoice->toPdfInvoice()->download();
    }
}