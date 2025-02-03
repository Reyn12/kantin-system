<div class="bg-white rounded-xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Riwayat Transaksi</h2>
        <div class="text-sm text-gray-500">10 transaksi terakhir</div>
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
                    <th class="pb-4">Kasir</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($transaksi as $t)
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
                        <td>{{ $t['tanggal']->format('d M Y, H:i') }}</td>
                        <td>{{ $t['customer'] }}</td>
                        <td>{{ $t['kasir'] }}</td>
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