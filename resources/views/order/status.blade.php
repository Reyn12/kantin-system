@extends('order.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Status Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Diterima!</h1>
            <p class="text-gray-600">Mohon tunggu pesananmu sedang diproses</p>
        </div>

        <!-- Customer Info -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Detail Pesanan:</h2>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="mb-2"><span class="font-medium">Nama:</span> {{ $customer['name'] }}</p>
                <p class="mb-2"><span class="font-medium">No. Telepon:</span> {{ $customer['phone'] }}</p>
                <p><span class="font-medium">No. Meja:</span> {{ $customer['table'] }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Pesanan:</h2>
            <div class="space-y-3">
                @foreach($cart as $id => $item)
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    <p class="font-medium">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="border-t pt-4">
            <div class="flex justify-between items-center text-lg font-bold">
                <p>Total:</p>
                <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('order.menu') }}" class="inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                Kembali ke Menu
            </a>
        </div>
    </div>
</div>
@endsection