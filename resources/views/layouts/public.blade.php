<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', 'Home') - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-industrial-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-12">
                        <span class="text-2xl font-bold text-primary-400">FTHERM</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="hover:text-primary-400 transition {{ request()->routeIs('home') ? 'text-primary-400' : '' }}">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('home') }}#services" class="hover:text-primary-400 transition">
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('shop.index') }}" class="hover:text-primary-400 transition {{ request()->routeIs('shop.*') ? 'text-primary-400' : '' }}">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('home') }}#contact" class="hover:text-primary-400 transition">
                        {{ __('Contact') }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex space-x-2">
                        <a href="{{ change_locale_url('en') }}" class="px-2 py-1 rounded {{ current_locale() === 'en' ? 'bg-primary-600 text-white' : 'hover:bg-industrial-800' }}">EN</a>
                        <a href="{{ change_locale_url('sr') }}" class="px-2 py-1 rounded {{ current_locale() === 'sr' ? 'bg-primary-600 text-white' : 'hover:bg-industrial-800' }}">SR</a>
                        <a href="{{ change_locale_url('hu') }}" class="px-2 py-1 rounded {{ current_locale() === 'hu' ? 'bg-primary-600 text-white' : 'hover:bg-industrial-800' }}">HU</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-industrial-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-primary-400 mb-4">FTHERM</h3>
                    <p class="text-gray-400">
                        Professional heating and cooling solutions
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-white transition">Products</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>064 139 1360</li>
                        <li>farkas.tibor@ftherm.rs</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} FTherm. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
