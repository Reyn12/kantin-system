@extends('admin.layouts.app')

@section('title', 'product')

@section('content')
    @include('admin.components.header')
    
    {{-- Main Content --}}
    {{-- Main Content --}}
    <div class="flex flex-col gap-6 px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Manajemen Produk</h2>
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Produk
            </button>
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $product->gambar_url) }}" 
                                     alt="{{ $product->nama_produk }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                            </td>
                            <td class="px-6 py-4">{{ $product->nama_produk }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($product->harga * 1000, 0, ',', '.') }}</td>
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
                                <div class="flex gap-2">
                                    <button onclick="openModal('editProductModal', {{ $product->id }})" 
                                            class="text-blue-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteProduct({{ $product->id }})" 
                                            class="text-red-500 hover:text-red-600">
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
    </div>

    {{-- Add/Edit Product Modal --}}
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h3>
            <form id="productForm" class="space-y-4" onsubmit="handleSubmit(event)">
                <input type="hidden" id="productId" value="">
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-3 py-2 border rounded-lg">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
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
    @push('scripts')
    <script>
        // Function untuk update status
        function updateStatus(id, status) {
            $.ajax({
                url: `/admin/products/${id}/status`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({ status: status }),
                contentType: 'application/json',
                success: function(data) {
                    $(`#status-text-${id}`).text(status ? 'Tersedia' : 'Tidak Tersedia');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1200,
                        showConfirmButton: false
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengupdate status'
                    });
                    $(`#status-toggle-${id}`).prop('checked', !status);
                }
            });
        }

        // Functions untuk handle modal
        function openModal(id = null) {
            const modal = $('#productModal');
            const form = $('#productForm');
            const title = $('#modalTitle');
            
            // Reset form
            form[0].reset();
            $('#productId').val(id);
            
            // Set title
            title.text(id ? 'Edit Produk' : 'Tambah Produk');
            
            // If editing, fill form with product data
            if (id) {
                $.get(`/admin/products/${id}/edit`, function(data) {
                    form.find('[name="nama_produk"]').val(data.nama_produk);
                    form.find('[name="category_id"]').val(data.category_id);
                    form.find('[name="deskripsi"]').val(data.deskripsi);
                    form.find('[name="harga"]').val(data.harga);
                    form.find('[name="stok"]').val(data.stok);
                });
            }
            
            // Show modal
            modal.removeClass('hidden').addClass('flex');
        }

        function closeModal() {
            $('#productModal').removeClass('flex').addClass('hidden');
        }

        function handleSubmit(event) {
            event.preventDefault();
            
            const form = $(event.target);
            const id = $('#productId').val();
            const formData = new FormData(form[0]);
            
            // Convert harga to database format (divide by 1000)
            formData.set('harga', parseInt(formData.get('harga')) / 1000);
            
            $.ajax({
                url: id ? `/admin/products/${id}` : '/admin/products',
                method: id ? 'PUT' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menyimpan produk'
                    });
                }
            });
        }

        // Function untuk delete produk
        function deleteProduct(id) {
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Produk yang dihapus ga bisa dikembaliin loh",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/products/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat menghapus produk'
                            });
                        }
                    });
                }
            });
        }
    </script>
    @endpush
@endsection