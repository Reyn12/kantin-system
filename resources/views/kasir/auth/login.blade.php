@extends('kasir.layouts.auth')
@section('title', 'Kasir Login')

@section('content')
<!-- Header -->
<div class="fixed top-0 left-0 right-0 bg-none bg-opacity-95 z-50 mx-10">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Unikom Kantin</h1>
        <div class="flex items-center space-x-4">
            <!-- Light/Dark Mode Toggle -->
            <div x-data="{ darkMode: false }" class="flex items-center space-x-2">
                <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </div>
            <a href="/" class="px-4 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition-colors">Homepage</a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="min-h-screen flex items-center justify-center" style="background-image: url('{{ asset('images/bgAdminLogin.png') }}'); background-size: cover; background-position: center;">
    <!-- Form Login di Tengah -->
    <div class="w-full max-w-md bg-white p-8 rounded-[40px] shadow-lg mx-4 mt-10">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-center mb-4">Kasir Login</h2>
            <p class="text-center text-gray-600 text-sm">Login dengan menggunakan </p>
            <p class="text-center text-gray-600 text-sm">email dan password</p>
        </div>

        <form action="{{ route('kasir.login') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <div class="relative">
                    <input type="email" name="email" id="email" 
                        class="w-full px-4 py-3 border rounded-2xl pr-10 focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" 
                        placeholder="Enter Email">
                    <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            
            <div>
                <div class="relative">
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-3 border rounded-2xl pr-10 focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" 
                        placeholder="Password">
                    <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-lg hover:bg-blue-800 transition-colors">
                Sign In
            </button>
        </form>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: 'Email atau password salah',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                popup: 'rounded-[20px]',
                title: 'font-bold text-xl mb-4',
                content: 'text-gray-600'
            }
        });
    });
</script>
@endif
@endsection