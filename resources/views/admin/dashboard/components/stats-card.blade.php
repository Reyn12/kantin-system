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
                        <span class="px-1.5 py-0.5 bg-green-400/20 text-green-300 rounded text-xs">+24%</span>
                    </div>
                    <div class="text-2xl font-bold mt-1">Rp350.000</div>
                    <div class="text-sm opacity-80">Kemarin: Rp170.000</div>
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
                        <span class="px-1.5 py-0.5 bg-green-400/20 text-green-300 rounded text-xs">+14%</span>
                    </div>
                    <div class="text-2xl font-bold mt-1">45</div>
                    <div class="text-sm opacity-80">Kemarin: 32</div>
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
                        <span class="px-1.5 py-0.5 bg-green-400/20 text-green-300 rounded text-xs">+43%</span>
                    </div>
                    <div class="text-xl font-bold mt-1">Nasi Goreng</div>
                    <div class="text-sm opacity-80">Terjual: 15 porsi</div>
                </div>
            </div>
        </div>
    </div>
</div>