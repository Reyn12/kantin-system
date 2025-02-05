<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>
    
    {{-- Font Lato --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    {{-- Custom Styles --}}
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-white via-blue-50  to-white">
    <div class="flex h-screen bg-gradient-to-b from-white via-blue-50  to-white overflow-hidden">
        @include('admin.components.sidebar')

        {{-- Main Content --}}
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <main class="flex-1 relative overflow-y-auto focus:outline-none pt-16 md:pt-0">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-4">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Scripts --}}
    @vite('resources/js/app.js')

    {{-- Flash Message --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>