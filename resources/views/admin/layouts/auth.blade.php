<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Admin Panel</title>
    
    {{-- Font Lato --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- Custom Styles --}}
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <main>
        @yield('content')
    </main>

    {{-- Scripts --}}
    @vite('resources/js/app.js')

    {{-- Flash Message --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
</body>
</html>