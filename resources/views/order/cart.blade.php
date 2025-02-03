@extends('order.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with back button -->
    <div class="flex items-center mb-6">
        <a href="{{ route('order.menu') }}" class="mr-4">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <h1 class="text-2xl font-bold">Keranjang</h1>
    </div>
    
    @php
        $cart = session()->get('cart', []);
        $total = 0;
    @endphp
    
    @if(count($cart) > 0)
        <div class="space-y-4 mb-24"> <!-- Added margin bottom for fixed checkout bar -->
            @foreach($cart as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <div class="bg-white rounded-xl p-4">
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            <h3 class="font-medium">{{ $details['name'] }}</h3>
                            <p class="text-orange-500 font-semibold">Rp {{ number_format($details['price']) }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quantity controls -->
                            <div class="flex items-center bg-gray-100 rounded-lg">
                                <button onclick="updateCart({{ $id }}, {{ $details['quantity'] - 1 }})" 
                                        class="w-8 h-8 flex items-center justify-center text-gray-600">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="w-8 text-center">{{ $details['quantity'] }}</span>
                                <button onclick="updateCart({{ $id }}, {{ $details['quantity'] + 1 }})" 
                                        class="w-8 h-8 flex items-center justify-center text-gray-600">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            <!-- Delete button -->
                            <button onclick="removeFromCart({{ $id }})" 
                                    class="text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Subtotal for this item -->
                    <div class="mt-2 text-sm text-gray-500">
                        Subtotal: Rp {{ number_format($details['price'] * $details['quantity']) }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Fixed checkout bar at bottom -->
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-gray-500">Total Pesanan:</p>
                        <p class="text-xl font-bold">Rp {{ number_format($total) }}</p>
                    </div>
                    <form action="{{ route('order.cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-orange-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                            Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-gray-300 text-5xl"></i>
            </div>
            <p class="text-gray-500 mb-6">Keranjang kamu masih kosong</p>
            <a href="{{ route('order.menu') }}" 
               class="inline-block bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                Kembali ke Menu
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
    if (!confirm('Yakin ingin menghapus item ini?')) return;
    
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