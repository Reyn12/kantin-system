<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Kantin System</title>
    
    {{-- Font Lato --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')
    
    {{-- Custom Styles --}}
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
    </style>
    
    {{-- Stack untuk custom styles --}}
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    {{-- Navbar --}}
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800">
                        Kantin System
                    </a>
                </div>
                
                {{-- Navigation Links --}}
                <div class="flex items-center">
                    @yield('navbar-content')
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow-md mt-auto">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500">
                &copy; {{ date('Y') }} Kantin System. All rights reserved.
            </p>
        </div>
    </footer>

    {{-- Scripts --}}
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>