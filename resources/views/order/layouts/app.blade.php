<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Order Menu' }}</title>
    
    {{-- Font Lato --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS & JS dari build --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-BKqvJM9i.css') }}">
    <script type="module" src="{{ asset('build/assets/app-Xaw6OIO1.js') }}"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- QR Scanner --}}
    <script src="https://unpkg.com/html5-qrcode"></script>

    {{-- Tailwind CSS --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    {{-- Custom Styles --}}
    <style>
        html, body {
            font-family: 'Lato', sans-serif;
            overscroll-behavior-y: contain;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Main Container -->
    <div class="min-h-screen max-w-md mx-auto bg-white shadow-sm">
        <!-- Top Navigation (optional) -->
        <div class="sticky top-0 z-50 bg-white border-b">
            @yield('nav')
        </div>

        <!-- Main Content -->
        <main class="pb-32"> <!-- Extra padding bottom for cart -->
            @yield('content')
        </main>

        <!-- Bottom Sheet Cart -->
        <div x-data="{ open: false }" 
             class="fixed bottom-0 left-0 right-0 z-40 max-w-md mx-auto">
            <!-- Cart Preview (when closed) -->
            <div x-show="!open" 
                 class="bg-white border-t shadow-lg p-4">
                @yield('cart-preview')
            </div>

            <!-- Full Cart (when opened) -->
            <div x-show="open" 
                 x-transition
                 class="bg-white border-t shadow-lg h-[80vh] overflow-y-auto">
                @yield('cart-full')
            </div>
        </div>
    </div>

    <!-- Stack Notifications -->
    <div class="fixed top-4 right-4 z-50">
        @yield('notifications')
    </div>

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>