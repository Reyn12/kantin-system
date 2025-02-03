@extends('admin.layouts.app')

@section('content')
    @include('admin.components.header')
    
    {{-- Main Content --}}
    <div class="flex flex-col gap-6 px-4">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Order</h1>
                <p class="text-sm text-gray-600">Kelola semua order pelanggan disini</p>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-400 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Kasir</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">No Meja</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Total</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Status</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="even:bg-gray-50 odd:bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->kasir->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->nomor_meja }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->total_harga }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($order->status)
                                        @case('menunggu_pembayaran')
                                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Menunggu Pembayaran
                                            </span>
                                        @break
                                        @case('dibayar')
                                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Dibayar
                                            </span>
                                        @break
                                        @case('diproses')
                                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                Diproses
                                            </span>
                                        @break
                                        @case('selesai')
                                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Selesai
                                            </span>
                                        @break
                                        @case('dibatalkan')
                                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Dibatalkan
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button onclick="viewOrder({{ $order->id }})" 
                                            class="bg-blue-100 hover:bg-blue-200 p-2 rounded-lg text-blue-600 hover:text-blue-700 transition-colors duration-200 px-3 py-3">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="updateStatus({{ $order->id }})" 
                                            class="bg-green-100 hover:bg-green-200 p-2 rounded-lg text-green-600 hover:text-green-700 transition-colors duration-200 px-3 py-3">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada order
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal View Order --}}
    <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-xl max-w-4xl w-full mx-4">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Detail Order</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div id="orderDetails">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function viewOrder(id) {
        $.get(`/admin/orders/${id}/edit`, function(order) {
            console.log('Order data:', order);
            console.log('Order items:', order.order_items);
            console.log('First product:', order.order_items[0]?.product);
            let details = `
                <div class="grid grid-cols-2 gap-8">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-800 mb-3">Informasi Order</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Order ID</span>
                                    <span class="font-medium">#${order.id}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Status</span>
                                    <span class="px-2 py-1 text-xs rounded-full font-semibold
                                        ${order.status === 'completed' ? 'bg-green-100 text-green-800' : 
                                          (order.status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                          (order.status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                          'bg-yellow-100 text-yellow-800'))}">
                                        ${order.status.toUpperCase()}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tanggal</span>
                                    <span class="font-medium">${new Date(order.created_at).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-bold text-purple-800 mb-3">Informasi Pelanggan</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nama</span>
                                    <span class="font-medium">${order.customer.name}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Kasir</span>
                                    <span class="font-medium">${order.kasir.name}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nomor Meja</span>
                                    <span class="font-medium">${order.nomor_meja}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-bold text-green-800 mb-3">Detail Pesanan</h4>
                            <div class="space-y-3">
                                ${order.order_items && order.order_items.length > 0 ? 
                                    order.order_items.map(item => {
                                        const jumlah = item.jumlah || 0;
                                        const harga = item.harga_satuan || 0;
                                        const subtotal = item.subtotal || 0;
                                        return `
                                        <div class="flex justify-between items-center py-2 border-b border-green-100 last:border-0">
                                            <div>
                                                <p class="font-medium">${item.product.nama_produk}</p>
                                                <p class="text-sm text-gray-500">${jumlah}x @ Rp ${harga}</p>
                                            </div>
                                            <span class="font-medium">
                                                Rp ${subtotal}
                                            </span>
                                        </div>
                                        `;
                                    }).join('')
                                    : '<p class="text-gray-500 text-center">Tidak ada item</p>'
                                }
                                <div class="flex justify-between pt-3 border-t border-green-200">
                                    <span class="font-bold text-green-800">Total</span>
                                    <span class="font-bold text-green-800">Rp ${order.total_harga}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-800 mb-3">Catatan</h4>
                            <p class="text-gray-600">${order.catatan || '-'}</p>
                        </div>
                    </div>
                </div>
            `;
            $('#orderDetails').html(details);
            $('#orderModal').removeClass('hidden').addClass('flex');
        });
    }

    function closeModal() {
        $('#orderModal').removeClass('flex').addClass('hidden');
    }

    function updateStatus(id) {
        Swal.fire({
            title: '<h3 class="text-xl font-bold text-gray-900">Update Status Order</h3>',
            html: `
                <div class="space-y-4">
                    <select id="status-select" class="w-full px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="menunggu_pembayaran" class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-2 bg-yellow-400 rounded-full"></span>
                            Menunggu Pembayaran
                        </option>
                        <option value="dibayar" class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-2 bg-blue-400 rounded-full"></span>
                            Dibayar
                        </option>
                        <option value="diproses" class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-2 bg-purple-400 rounded-full"></span>
                            Diproses
                        </option>
                        <option value="selesai" class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-2 bg-green-400 rounded-full"></span>
                            Selesai
                        </option>
                        <option value="dibatalkan" class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-2 bg-red-400 rounded-full"></span>
                            Dibatalkan
                        </option>
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md',
                cancelButton: 'px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-md ml-3'
            },
            preConfirm: () => {
                const status = document.getElementById('status-select').value;
                return $.ajax({
                    url: `/admin/orders/${id}`,
                    type: 'PUT',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Status order berhasil diupdate',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md'
                    }
                }).then(() => location.reload());
            }
        });
    }
</script>
@endpush