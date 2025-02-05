@extends('order.layouts.app')

@section('content')
<div x-data="formHandler()">
    <!-- Header -->
    <div class="text-center p-6 bg-white">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang!</h1>
        <p class="text-gray-600 mt-2">Scan QR atau masukkan nomor meja untuk mulai pesan</p>
    </div>

    <!-- Tab Navigation -->
    <div class="flex border-b bg-white">
        <button 
            @click="activeTab = 'scan'" 
            :class="{ 'border-b-2 border-primary text-primary': activeTab === 'scan' }"
            class="flex-1 py-3 text-center font-medium">
            <i class="fas fa-qrcode mr-2"></i>
            Scan QR
        </button>
        <button 
            @click="activeTab = 'manual'" 
            :class="{ 'border-b-2 border-primary text-primary': activeTab === 'manual' }"
            class="flex-1 py-3 text-center font-medium">
            <i class="fas fa-keyboard mr-2"></i>
            Input Manual
        </button>
    </div>
 
    <!-- Content Area -->
    <div class="p-6">
        <!-- QR Scanner Tab -->
        <div x-show="activeTab === 'scan'" x-transition>
            @include('order.components.qr-scanner')
        </div>

        <!-- Manual Input Tab -->
        <div x-show="activeTab === 'manual'" x-transition>
            <form @submit.prevent="submitForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor Meja
                        </label>
                        <input 
                            type="text" 
                            name="table_number"
                            x-model="tableNumber"
                            class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition"
                            placeholder="Masukkan nomor meja..."
                            required>
                    </div>
                </div>
                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full mt-6 px-6 py-3 bg-orange-500 text-white font-medium rounded-lg shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all"
                    :disabled="isLoading">
                    <span x-show="!isLoading">Mulai Pesan</span>
                    <span x-show="isLoading">
                        <i class="fas fa-spinner fa-spin"></i>
                        Loading...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function formHandler() {
    return {
        activeTab: 'scan',
        tableNumber: '',
        isLoading: false,
        async submitForm() {
            if (!this.tableNumber) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nomor meja harus diisi!'
                });
                return;
            }

            this.isLoading = true;

            try {
                const formData = new FormData();
                formData.append('table_number', this.tableNumber);
                formData.append('input_type', 'manual');

                const response = await fetch('{{ route('order.set-table') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Nomor meja berhasil disimpan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.message || 'Gagal memproses nomor meja');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Terjadi kesalahan!'
                });
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>
@endpush