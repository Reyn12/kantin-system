@extends('admin.layouts.app')

@section('title', 'product')

@section('content')
    @include('admin.components.header')
    
    {{-- Main Content --}}
    <div class="flex flex-col gap-6 px-4">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
            <h2 class="text-2xl font-bold">Manajemen Produk</h2>
            <div class="flex flex-col sm:flex-row w-full md:w-auto gap-2">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="w-full md:w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="openDownloadModal()" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="fas fa-download"></i>
                    Download
                </button>
                <button onclick="openModal()" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Produk
                </button>
            </div>
        </div>

        {{-- Table Section --}}
        @include('admin.products.components.table')
    </div>

    {{-- Add/Edit Product Modal --}}
    @include('admin.products.components.modal-add-edit')

    {{-- Download Modal --}}
    <div id="downloadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-[500px]">
            <h3 class="text-xl font-bold mb-6 text-center">Download Data Produk</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <button onclick="downloadFile('pdf')" class="bg-white border-2 border-red-500 hover:bg-red-50 text-red-500 p-4 rounded-lg flex flex-col items-center gap-3">
                    <i class="fas fa-file-pdf text-4xl"></i>
                    <span class="font-semibold">Download PDF</span>
                </button>
                <button onclick="downloadFile('excel')" class="bg-white border-2 border-green-500 hover:bg-green-50 text-green-500 p-4 rounded-lg flex flex-col items-center gap-3">
                    <i class="fas fa-file-excel text-4xl"></i>
                    <span class="font-semibold">Download Excel</span>
                </button>
            </div>
            <button onclick="closeDownloadModal()" class="w-full bg-gray-100 hover:bg-gray-200 py-2 rounded-lg text-gray-600 font-medium">
                Tutup
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (productName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

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

        // Function untuk handle modal download
        function openDownloadModal() {
            $('#downloadModal').removeClass('hidden').addClass('flex');
        }

        function closeDownloadModal() {
            $('#downloadModal').removeClass('flex').addClass('hidden');
        }

        function downloadFile(type) {
            let url = '';
            if (type === 'pdf') {
                url = '{{ route("admin.products.download.pdf") }}';
            } else if (type === 'excel') {
                url = '{{ route("admin.products.download.excel") }}';
            }
            
            window.location.href = url;
            closeDownloadModal();
        }
    </script>
    @endpush
@endsection