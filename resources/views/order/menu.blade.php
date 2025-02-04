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
<div class="max-w-md container mx-auto px-4 py-8">
    
    <!-- Toast Container -->
    <div id="toast" class="fixed top-0 left-0 right-0 transform -translate-y-full transition-transform duration-300 ease-in-out z-50">
        <div class="bg-black bg-opacity-80 text-white p-4 mx-4 mt-4 rounded-xl">
            <div class="text-center">
                <p class="font-medium mb-2" id="toastMessage">Produk berhasil ditambahkan ke keranjang!</p>
                <button onclick="hideToast()" class="text-blue-400">Oke</button>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-md mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold">Menu Kami</h1>
                    <p class="text-sm text-gray-500">Kantin System</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('order.cart') }}" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartCount" class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 text-white text-xs rounded-full flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
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
                        <span class="font-semibold text-sm">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
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

<!-- Selected Items Bar -->
<div id="selectedItemsBar" class="fixed bottom-10 lg:bottom-10 left-10 right-10 bg-white shadow-lg transform translate-y-full transition-transform duration-300 ease-in-out rounded-2xl lg:mx-96">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="text-sm">
                <span id="selectedItemsCount">0</span> Items selected
            </div>
            <div class="text-orange-500 font-semibold" id="totalPrice">
                Rp 0
            </div>
            <button onclick="proceedToCheckout()" class="bg-orange-500 text-white px-4 py-2 rounded-lg">
                Checkout
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cartItems = [];
let totalPrice = 0;

function showSelectedItemsBar() {
    const bar = document.getElementById('selectedItemsBar');
    bar.classList.remove('translate-y-full');
}

function hideSelectedItemsBar() {
    const bar = document.getElementById('selectedItemsBar');
    bar.classList.add('translate-y-full');
}

function updateSelectedItemsBar() {
    const count = document.getElementById('selectedItemsCount');
    const price = document.getElementById('totalPrice');
    const cartCount = document.getElementById('cartCount');
    
    count.textContent = cartItems.length;
    cartCount.textContent = cartItems.length;
    price.textContent = `Rp ${totalPrice.toLocaleString()}`;
    
    if (cartItems.length > 0) {
        showSelectedItemsBar();
    } else {
        hideSelectedItemsBar();
    }
}

function addToCart(productId) {
    // Ambil info produk dari elemen HTML
    const productElement = event.target.closest('.bg-white');
    const name = productElement.querySelector('h3').textContent;
    const priceText = productElement.querySelector('.font-semibold').textContent;
    const price = parseInt(priceText.replace(/[^0-9]/g, ''));
    
    // Update local state
    cartItems.push({
        id: productId,
        name: name,
        price: price
    });
    totalPrice += price;
    updateSelectedItemsBar();
    
    // Sync dengan session cart
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
            showToast('Produk berhasil ditambahkan ke keranjang!');
        } else {
            showToast('Gagal menambahkan produk ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan saat menambahkan ke keranjang');
    });
}

function proceedToCheckout() {
    window.location.href = '{{ route('order.cart') }}';
}

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
            if (data.success) {
                updateProducts(data.products);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat memuat produk');
        });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMessage').textContent = message;
    
    toast.classList.remove('-translate-y-full');
    setTimeout(() => {
        hideToast();
    }, 3000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('-translate-y-full');
}
</script>
@endpush
@endsection