@extends('order.layouts.app')
@php
function getCategoryIcon($category) {
    $icons = [
        'Makanan' => 'hamburger',
        'Minuman' => 'coffee',
        'Snack' => 'cookie-bite',
        'Dessert' => 'ice-cream',
        // Tambah sesuai kategori yang ada
    ];
    
    return $icons[strtolower($category)] ?? 'utensils';
}
@endphp
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Menu Kami</h1>
    
    <!-- Categories -->
    <div class="flex overflow-x-auto space-x-4 mb-6 px-2">
        <button onclick="filterByCategory('all')" 
                class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-1">
                <i class="fas fa-utensils text-orange-500"></i>
            </div>
            <span class="text-xs">Semua</span>
        </button>
        @foreach($categories as $category)
            <button onclick="filterByCategory({{ $category->id }})"
                    class="flex flex-col items-center p-3 bg-white rounded-xl shadow-sm">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-1">
                    <i class="fas fa-{{ getCategoryIcon($category->nama_kategori) }} text-orange-500"></i>
                </div>
                <span class="text-xs">{{ $category->nama_kategori }}</span>
            </button>
        @endforeach
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 gap-4 px-2">
        @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @php
                    $staticImagePath = 'images/products/' . basename($product->gambar_url);
                    $staticImageExists = file_exists(public_path($staticImagePath));
                @endphp
                
                <img src="{{ $staticImageExists 
                        ? asset($staticImagePath) 
                        : asset('storage/' . $product->gambar_url) }}" 
                    alt="{{ $product->nama_produk }}"
                    class="w-full h-32 object-cover">
                <div class="p-3">
                    <h3 class="font-medium text-sm">{{ $product->nama_produk }}</h3>
                    <p class="text-gray-500 text-xs">{{ $product->kategori ?? 'Main Course' }}</p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="font-semibold text-sm">Rp {{ number_format($product->harga * 1000) }}</span>
                        <button onclick="addToCart({{ $product->id }})" 
                                class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center hover:bg-orange-600">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

@push('scripts')
<script>
function filterByCategory(categoryId) {
    // Reset semua button jadi abu-abu
    document.querySelectorAll('.flex.overflow-x-auto button').forEach(btn => {
        btn.classList.remove('bg-orange-100');
        btn.querySelector('div').classList.add('bg-gray-100');
    });

    // Set button yang dipilih jadi orange
    if (categoryId === 'all') {
        document.querySelector('.flex.overflow-x-auto button:first-child div')
            .classList.replace('bg-gray-100', 'bg-orange-100');
    } else {
        event.target.closest('button').querySelector('div')
            .classList.replace('bg-gray-100', 'bg-orange-100');
    }

    // Fetch produk berdasarkan kategori
    fetch(`/order/products/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.querySelector('.grid');
            productsContainer.innerHTML = data.products.map(product => `
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <img src="${product.image_url}" 
                         alt="${product.nama_produk}"
                         class="w-full h-32 object-cover">
                    <div class="p-3">
                        <h3 class="font-medium text-sm">${product.nama_produk}</h3>
                        <p class="text-gray-500 text-xs">${product.kategori || 'Main Course'}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="font-semibold text-sm">Rp ${Number(product.harga * 1000).toLocaleString()}</span>
                            <button onclick="addToCart(${product.id})" 
                                    class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center hover:bg-orange-600">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        });
}

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