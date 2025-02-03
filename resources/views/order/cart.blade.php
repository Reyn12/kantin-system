{{-- resources/views/order/cart.blade.php --}}
@extends('order.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang</h1>
    
    @php
        $cart = session()->get('cart', []);
        $total = 0;
    @endphp
    
    @if(count($cart) > 0)
        <div class="space-y-4">
            @foreach($cart as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold">{{ $details['name'] }}</h3>
                        <p class="text-gray-600">Rp {{ number_format($details['price']) }} x {{ $details['quantity'] }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateCart({{ $id }}, {{ $details['quantity'] - 1 }})" 
                                class="px-2 py-1 bg-gray-200 rounded">-</button>
                        <span>{{ $details['quantity'] }}</span>
                        <button onclick="updateCart({{ $id }}, {{ $details['quantity'] + 1 }})" 
                                class="px-2 py-1 bg-gray-200 rounded">+</button>
                        <button onclick="removeFromCart({{ $id }})" 
                                class="ml-4 text-red-500">🗑️</button>
                    </div>
                </div>
            @endforeach
            
            <div class="mt-6 bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold">Total:</span>
                    <span class="font-bold text-xl">Rp {{ number_format($total) }}</span>
                </div>
                <form action="{{ route('order.cart.checkout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark">
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <p class="text-gray-600">Keranjang kamu masih kosong</p>
            <a href="{{ route('order.menu') }}" 
               class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded-lg">
                Lihat Menu
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateCart(productId, quantity) {
    if (quantity < 1) {
        removeFromCart(productId);
        return;
    }
    
    fetch('{{ route('order.cart.update') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}

function removeFromCart(productId) {
    fetch('{{ route('order.cart.remove') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>
@endpush
@endsection