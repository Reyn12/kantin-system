<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            text-align: left;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            color: #1a237e;
            margin: 0;
        }
        .status {
            color: #4CAF50;
            font-weight: bold;
        }
        .bill-info {
            margin-bottom: 30px;
        }
        .bill-info div {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .description {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice</h1>
        <div class="status">Paid</div>
    </div>

    <div class="bill-info">
        <div>
            <strong>Invoice number:</strong> IN{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
        </div>
        <div>
            <strong>Date of issue:</strong> {{ $order->created_at->format('Y-m-d') }}
        </div>
    </div>

    <div class="bill-info">
        <div style="float: left; width: 50%;">
            <h3>Bill From</h3>
            <div>{{ $order->kasir->name }}</div>
            <div>{{ $order->kasir->email }}</div>
        </div>
        <div style="float: right; width: 50%;">
            <h3>Bill To</h3>
            <div>{{ $order->customer->name }}</div>
            <div>{{ $order->customer->email }}</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    {{ $item->product->nama_produk }}
                    <br>
                    <small>{{ $item->product->deskripsi }}</small>
                </td>
                <td>{{ $item->jumlah }}</td>
                <td>IDR {{ number_format($item->harga_satuan * 1000, 2) }}</td>
                <td>IDR {{ number_format($item->subtotal * 1000, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <div>Subtotal: IDR {{ number_format($order->orderItems->sum('subtotal') * 1000, 2) }}</div>
        <div style="font-size: 1.2em; margin-top: 10px;">
            Total: IDR {{ number_format($order->orderItems->sum('subtotal') * 1000, 2) }}
        </div>
    </div>

    <div class="description">
        <h3>Description</h3>
        <p>Invoice Meja {{ $order->nomor_meja }} untuk {{ $order->customer->name }} pada {{ $order->created_at->format('d F Y') }}</p>
    </div>
</body>
</html>