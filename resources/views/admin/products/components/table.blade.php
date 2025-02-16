<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-indigo-400 text-white">
                <tr>
                    <th class="px-6 py-3">Gambar</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                <tr class="even:bg-gray-50 odd:bg-white hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @php
                            $staticImagePath = 'images/products/' . basename($product->gambar_url);
                            $staticImageExists = file_exists(public_path($staticImagePath));
                        @endphp
                        
                        <img src="{{ $staticImageExists 
                                  ? asset($staticImagePath) 
                                  : asset('storage/' . $product->gambar_url) }}" 
                             alt="{{ $product->nama_produk }}" 
                             class="w-16 h-16 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4">{{ $product->nama_produk }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <input type="number" value="{{ $product->stok }}" 
                               class="w-20 px-2 py-1 border rounded-lg"
                               onchange="updateStock({{ $product->id }}, this.value)">
                    </td>
                    <td class="px-6 py-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                                   id="status-toggle-{{ $product->id }}"
                                   {{ $product->status === 'tersedia' ? 'checked' : '' }}
                                   onchange="updateStatus({{ $product->id }}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-2 text-sm text-gray-600" id="status-text-{{ $product->id }}">
                                {{ $product->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </label>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-4">
                            <button onclick="openModal({{ $product->id }})" 
                                class="bg-blue-100 hover:bg-blue-200 p-2 rounded-lg text-blue-600 hover:text-blue-700 transition-colors duration-200 px-3 py-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteProduct({{ $product->id }})" 
                                    class="bg-red-100 hover:bg-red-200 p-2 rounded-lg text-red-600 hover:text-red-700 transition-colors duration-200 px-3 py-3">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>