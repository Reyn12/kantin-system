<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h3>
        <form id="productForm" class="space-y-4" onsubmit="handleSubmit(event)">
            <input type="hidden" id="productId" value="">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Pilih Kategori</option>
                    @forelse($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @empty
                        <option value="" disabled>Belum ada kategori</option>
                    @endforelse
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" name="harga" class="w-full px-3 py-2 border rounded-lg" 
                       placeholder="Contoh: 15000">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Stok</label>
                <input type="number" name="stok" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Gambar</label>
                <input type="file" name="gambar" accept="image/*" class="w-full">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>