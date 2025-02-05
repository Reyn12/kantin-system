{{-- Stats Cards --}}
<div class="bg-indigo-500 rounded-xl p-6 text-white shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Pendapatan Hari Ini --}}
        <div>
            <div class="flex items-center gap-8 md:gap-3 mb-6 lg:mb-0">
                <div class="w-12 h-12 bg-yellow-300 rounded-full flex items-center justify-center">
                    <i class="fas fa-wallet text-xl text-indigo-600"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span>Pendapatan Hari Ini</span>
                        @if($persentasePendapatan > 0)
                            <span class="px-1.5 py-0.5 bg-green-400/20 text-green-300 rounded text-xs">+{{ $persentasePendapatan }}%</span>
                        @elseif($persentasePendapatan <= 0)
                            <span class="px-1.5 py-0.5 bg-red-400/20 text-red-300 rounded text-xs">{{ $persentasePendapatan }}%</span>
                        @endif
                    </div>
                    <div class="text-2xl font-bold mt-1">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                    <div class="text-sm opacity-80">Kemarin: Rp{{ number_format($pendapatanKemarin, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        {{-- Total Pesanan --}}
        <div>
            <div class="flex items-center gap-8 md:gap-3 mb-6 lg:mb-0">
                <div class="w-12 h-12 bg-green-300 rounded-full flex items-center justify-center">
                    <i class="fas fa-utensils text-xl text-indigo-600"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span>Total Pesanan</span>
                        @if($persentasePesanan > 0)
                            <span class="px-1.5 py-0.5 bg-green-400/20 text-green-300 rounded text-xs">+{{ $persentasePesanan }}%</span>
                        @elseif($persentasePesanan <= 0)
                            <span class="px-1.5 py-0.5 bg-red-400/20 text-red-300 rounded text-xs">{{ $persentasePesanan }}%</span>
                        @endif
                    </div>
                    <div class="text-2xl font-bold mt-1">{{ $pesananHariIni }}</div>
                    <div class="text-sm opacity-80">Kemarin: {{ $pesananKemarin }}</div>
                </div>
            </div>
        </div>
        
        {{-- Menu Terlaris --}}
        <div>
            <div class="flex items-center gap-8 md:gap-3">
                <div class="w-12 h-12 bg-orange-300 rounded-full flex items-center justify-center">
                    <i class="fas fa-crown text-xl text-indigo-600"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span>Menu Terlaris</span>
                    </div>
                    <div class="text-xl font-bold mt-1">{{ $menuTerlaris->product->nama_produk ?? 'Belum ada' }}</div>
                    <div class="text-sm opacity-80">Terjual: {{ $menuTerlaris->total_terjual ?? 0 }} porsi</div>
                </div>
            </div>
        </div>
    </div>
</div>