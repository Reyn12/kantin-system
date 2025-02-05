<div class="bg-white rounded-xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Pesanan yang belum dibayar</h2>
        <div class="text-sm text-gray-500">Semua transaksi yang belum dibayar</div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-gray-500">
                    <th class="pb-4">ID</th>
                    <th class="pb-4">Menu/Item</th>
                    <th class="pb-4">Total</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4">Tanggal</th>
                    <th class="pb-4">Customer</th>
                    <th class="pb-4">Cetak</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($unpaidOrders as $t)
                    <tr class="border-t">
                        <td class="py-4">#{{ $t['id'] }}</td>
                        <td>{{ $t['nama_produk'] }}</td>
                        <td>Rp{{ number_format((float)$t['total'], 0, ',', '.') }}</td>
                        <td>
                            @switch($t['status'])
                                @case('pending')
                                @case('menunggu_pembayaran')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm">
                                        Menunggu Pembayaran
                                    </span>
                                    @break
                                @case('paid')
                                @case('dibayar')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                                        Dibayar
                                    </span>
                                    @break
                                @case('processing')
                                @case('diproses')
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">
                                        Diproses
                                    </span>
                                    @break
                                @case('completed')
                                @case('selesai')
                                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-sm">
                                        Selesai
                                    </span>
                                    @break
                                @case('cancelled')
                                @case('dibatalkan')
                                    <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-sm">
                                        Dibatalkan
                                    </span>
                                    @break
                                @default
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                        {{ ucfirst($t['status']) }}
                                    </span>
                            @endswitch
                        </td>
                        <td>{{ $t['tanggal'] ? $t['tanggal']->format('d M Y, H:i') : '-' }}</td>
                        <td>{{ $t['customer'] }}</td>
                        <td>
                            <button onclick="updateStatus({{ $t['id'] }})" class="bg-green-100 hover:bg-green-200 p-2 rounded-lg text-green-600 hover:text-green-700 transition-colors duration-200 px-3 py-3">
                                <i class="fas fa-check"></i>
                            </button>
                            <a href="{{ route('kasir.orders.invoice', ['id' => $t['id']]) }}" target="_blank">
                                <button class="bg-blue-100 hover:bg-blue-200 p-2 rounded-lg text-blue-600 hover:text-blue-700 transition-colors duration-200 px-3 py-3">
                                    <i class="fas fa-print"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td colspan="7" class="py-4 text-center text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Update Status Pesanan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah kamu yakin ingin mengubah status pesanan ini menjadi "Diproses"?
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="updateForm" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                        Ya, Proses Pesanan
                    </button>
                </form>
                <button onclick="closeModal()" class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function updateStatus(orderId) {
        // Set form action
        document.getElementById('updateForm').action = `/kasir/orders/${orderId}`;
        // Show modal
        document.getElementById('updateModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('updateModal').classList.add('hidden');
    }
</script>
@endpush