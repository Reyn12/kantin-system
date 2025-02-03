@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    @include('admin.components.header')
    
    {{-- Main Content --}}
    <div class="flex flex-col gap-6 px-4">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
            <h2 class="text-2xl font-bold">Manajemen Kategori</h2>
            <div class="flex w-full md:w-auto">
                <button onclick="openModal()" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Kategori
                </button>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-400 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">No</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs uppercase text-white font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $index => $category)
                            <tr class="even:bg-gray-50 odd:bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->nama_kategori }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2"> 
                                    <button onclick="editCategory({{ $category->id }})" class="bg-blue-100 hover:bg-blue-200 p-2 rounded-lg text-blue-600 hover:text-blue-700 transition-colors duration-200 px-3 py-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteCategory({{ $category->id }})" class="bg-red-100 hover:bg-red-200 p-2 rounded-lg text-red-600 hover:text-red-700 transition-colors duration-200 px-3 py-3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add/Edit Category Modal --}}
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-[500px]">
            <h3 id="modalTitle" class="text-xl font-bold mb-6">Tambah Kategori</h3>
            <form id="categoryForm" onsubmit="handleSubmit(event)">
                <input type="hidden" id="categoryId">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id = null) {
            const modal = $('#categoryModal');
            const title = $('#modalTitle');
            const form = $('#categoryForm')[0];
            
            form.reset();
            $('#categoryId').val('');
            
            if (id) {
                title.text('Edit Kategori');
                // Fetch category data and fill form
                $.get(`/admin/categories/${id}/edit`, function(data) {
                    console.log('Response data:', data);  // Tambah ini untuk debug
                    $('#categoryId').val(data.id);
                    $('#name').val(data.nama_kategori);
                }).fail(function(xhr) {
                    console.log('Error:', xhr);  // Tambah ini untuk debug error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengambil data kategori'
                    });
                });
            } else {
                title.text('Tambah Kategori');
            }
            
            modal.removeClass('hidden').addClass('flex');
        }

        function closeModal() {
            $('#categoryModal').removeClass('flex').addClass('hidden');
        }

        function handleSubmit(event) {
            event.preventDefault();
            
            const id = $('#categoryId').val();
            const url = id ? `/admin/categories/${id}` : '/admin/categories';
            const method = id ? 'PUT' : 'POST';
            
            const formData = {
                nama_kategori: $('#name').val()
            };

            $.ajax({
                url: url,
                method: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.message || 'Terjadi kesalahan!'
                    });
                }
            });
        }

        function editCategory(id) {
            openModal(id);
        }

        function deleteCategory(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kategori yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/categories/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.message || 'Terjadi kesalahan!'
                            });
                        }
                    });
                }
            });
        }
    </script>
    @endpush
@endsection