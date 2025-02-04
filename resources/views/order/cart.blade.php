@extends('order.layouts.app')

@section('content')
@php
        use Illuminate\Support\Facades\Log;

        $cart = session()->get('cart', []);
        $total = 0;
        $tableNumber = session('table_number');
        Log::info('Cart page - table number from session:', ['table_number' => $tableNumber]);
@endphp
<div class="max-w-md container mx-auto px-4 py-8 min-h-screen bg-yellow-50">
    <!-- Header with back button -->
    <div class="flex items-center mb-6">
        <a href="{{ route('order.menu') }}" class="mr-4">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <h1 class="text-2xl font-bold">Keranjang</h1>
    </div>
    
    @if(count($cart) > 0)
        <div class="space-y-4 mb-24"> <!-- Added margin bottom for fixed checkout bar -->
            @foreach($cart as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <div class="bg-white rounded-xl p-4">
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            <h3 class="font-medium">{{ $details['name'] }}</h3>
                            <p class="text-orange-500 font-semibold">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
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
                        Subtotal: Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Fixed checkout bar at bottom -->
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t lg:mx-[700px] rounded-2xl lg:mb-10">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-gray-500">Total Pesanan:</p>
                        <p class="text-xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    <button onclick="showCheckoutModal()" 
                            class="bg-orange-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
                <h2 class="text-xl font-bold mb-4">Data Pemesan</h2>
                <form action="{{ route('order.cart.checkout') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Nama</label>
                            <input type="text" name="customer_name" required
                                   class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"
                                   placeholder="Masukkan nama kamu">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" name="customer_phone" required
                                   class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"
                                   placeholder="Masukkan nomor telepon">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">No. Meja</label>
                            <input type="text" name="table_number" required readonly
                                   value="{{ $tableNumber }}"
                                   class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-500"
                                   placeholder="Masukkan nomor meja">
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <button type="button" onclick="hideCheckoutModal()"
                                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                                Konfirmasi
                            </button>
                        </div>
                    </div>
                </form>
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

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route('order.cart.update') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function removeFromCart(productId) {
    Swal.fire({
        title: 'Yakin hapus item ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('order.cart.remove') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Terhapus!',
                        'Item berhasil dihapus dari keranjang.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Gagal menghapus item.',
                    'error'
                );
            });
        }
    });
}

function showCheckoutModal() {
    document.getElementById('checkoutModal').classList.remove('hidden');
    document.getElementById('checkoutModal').classList.add('flex');
}

function hideCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
    document.getElementById('checkoutModal').classList.remove('flex');
}
</script>
@endpush