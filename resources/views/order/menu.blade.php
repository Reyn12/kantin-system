@extends('order.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Menu Kami</h1>
    
    <!-- Categories -->
    <div class="flex overflow-x-auto space-x-4 mb-6">
        <button class="px-4 py-2 bg-primary text-white rounded-lg">Semua</button>
        @foreach($categories as $category)
            <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $product->description }}</p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="font-bold text-primary">Rp {{ number_format($product->price) }}</span>
                        <button onclick="addToCart({{ $product->id }})" 
                                class="px-3 py-1 bg-primary text-white rounded-lg hover:bg-primary-dark">
                            + Tambah
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Cart Button (Fixed) -->
    <div class="fixed bottom-4 right-4">
        <a href="{{ route('order.cart') }}" 
           class="flex items-center space-x-2 bg-primary text-white px-4 py-2 rounded-full shadow-lg">
            <span>🛒</span>
            <span id="cartCount">0</span>
        </a>
    </div>
</div>

@push('scripts')
<script>
function addToCart(productId) {
    fetch('{{ route('order.cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            document.getElementById('cartCount').textContent = data.cartCount;
            alert('Produk berhasil ditambahkan ke keranjang!');
        } else {
            alert('Gagal menambahkan produk ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan ke keranjang');
    });
}
</script>
@endpush
@endsection