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
        @include('admin.products.components.table')
    </div>

    {{-- Add/Edit Product Modal --}}
    @include('admin.products.components.modal-add-edit')
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
            const methodField = $('#methodField');
            
            // Reset form
            form[0].reset();
            $('#productId').val(id);

            // Set method field
            methodField.val(id ? 'PUT' : 'POST');
            
            // Set title
            title.text(id ? 'Edit Produk' : 'Tambah Produk');
            
            // If editing, fill form with product data
            if (id) {
                $.get(`/admin/products/${id}/edit`, function(data) {
                    // Sekarang data.product karena response dari controller berubah
                    form.find('[name="nama_produk"]').val(data.product.nama_produk);
                    form.find('[name="category_id"]').val(data.product.category_id);
                    form.find('[name="deskripsi"]').val(data.product.deskripsi);
                    form.find('[name="harga"]').val(data.product.harga);
                    form.find('[name="stok"]').val(data.product.stok);
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
            
            // Basic form validation
            const form = event.target;
            const formData = new FormData(form);
            const productId = $('#productId').val();
            
            // Validation checks
            if (!formData.get('category_id')) {
                Swal.fire('Error', 'Pilih kategori dulu ya!', 'error');
                return;
            }
            
            if (!formData.get('nama_produk')) {
                Swal.fire('Error', 'Nama produk harus diisi ya!', 'error');
                return;
            }
            
            if (!formData.get('harga') || formData.get('harga') <= 0) {
                Swal.fire('Error', 'Harga harus lebih dari 0 ya!', 'error');
                return;
            }
            
            if (!formData.get('stok') || formData.get('stok') < 0) {
                Swal.fire('Error', 'Stok tidak boleh negatif ya!', 'error');
                return;
            }
            
            // Show loading state
            Swal.fire({
                title: 'Loading...',
                text: 'Lagi nyimpen produk nih...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // Tentukan URL dan method
            const url = productId ? `/admin/products/${productId}` : '/admin/products';
            
            // Jika ini update (PUT), tambahkan _method ke FormData
            if (productId) {
                formData.append('_method', 'PUT');
            }

            // Submit form
            $.ajax({
                url: url,
                method: 'POST', // Selalu POST, Laravel akan handle method spoofing
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: productId ? 'Produk berhasil diupdate' : 'Produk berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan. Coba lagi ya!';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    Swal.fire('Error', errorMessage, 'error');
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