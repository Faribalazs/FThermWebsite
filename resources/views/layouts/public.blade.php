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
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm backdrop-blur-lg bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-12 transition-transform group-hover:scale-110">
                        <span class="text-2xl font-bold text-primary-600">FTHERM</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-medium transition {{ request()->routeIs('home') ? 'text-primary-600' : 'text-gray-700 hover:text-primary-600' }}">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('home') }}#services" class="font-medium text-gray-700 hover:text-primary-600 transition">
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('shop.index') }}" class="font-medium transition {{ request()->routeIs('shop.*') ? 'text-primary-600' : 'text-gray-700 hover:text-primary-600' }}">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('home') }}#contact" class="font-medium text-gray-700 hover:text-primary-600 transition">
                        {{ __('Contact') }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex items-center gap-2 bg-light-100 rounded-lg p-1">
                        <a href="{{ change_locale_url('en') }}" class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ current_locale() === 'en' ? 'bg-primary-600 text-white shadow-sm' : 'text-gray-700 hover:bg-white' }}">EN</a>
                        <a href="{{ change_locale_url('sr') }}" class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ current_locale() === 'sr' ? 'bg-primary-600 text-white shadow-sm' : 'text-gray-700 hover:bg-white' }}">SR</a>
                        <a href="{{ change_locale_url('hu') }}" class="px-3 py-1.5 rounded-md text-sm font-medium transition {{ current_locale() === 'hu' ? 'bg-primary-600 text-white shadow-sm' : 'text-gray-700 hover:bg-white' }}">HU</a>
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
    <footer class="bg-gradient-to-br from-primary-900 to-primary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-10 w-10">
                        <span class="text-2xl font-bold">FTHERM</span>
                    </div>
                    <p class="text-primary-100 text-lg leading-relaxed max-w-md">
                        Professional heating and cooling solutions for modern living. Expert installation and maintenance services.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-primary-100 hover:text-white transition flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Home
                        </a></li>
                        <li><a href="{{ route('shop.index') }}" class="text-primary-100 hover:text-white transition flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Products
                        </a></li>
                        <li><a href="{{ route('home') }}#services" class="text-primary-100 hover:text-white transition flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Services
                        </a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-primary-100 hover:text-white transition flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Contact
                        </a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-secondary-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-primary-100">064 139 1360</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-secondary-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-primary-100 break-all">farkas.tibor@ftherm.rs</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-primary-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-primary-200 text-sm">&copy; {{ date('Y') }} FTherm. All rights reserved.</p>
                <p class="text-primary-200 text-sm">Built with <span class="text-secondary-400">♥</span> for modern HVAC solutions</p>
            </div>
        </div>
    </footer>
</body>
</html>
