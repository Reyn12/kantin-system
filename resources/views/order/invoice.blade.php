<html>
<head>
    <title>Invoice - Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .header { text-align: center; }
        .footer { text-align: center; margin-top: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
            <p>Tanggal: {{ now()->format('d-m-Y H:i') }}</p>
        </div>

        <h2>Detail Pelanggan:</h2>
        <p>Nama: {{ $customer['name'] }}</p>
        <p>No. Telepon: {{ $customer['phone'] }}</p>
        <p>No. Meja: {{ $customer['table'] }}</p>

        <h2>Detail Pesanan:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>
</html>