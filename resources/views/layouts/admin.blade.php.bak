<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', 'Admin Dashboard') - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-light-50 to-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-industrial-900 to-industrial-800 text-white flex-shrink-0 shadow-2xl">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3 animate-fade-in-up">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2 rounded-xl shadow-lg">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-8 w-8 transition-transform hover:scale-110">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">FTHERM</h1>
                        <p class="text-xs text-primary-300 font-medium">Admin Panel</p>
                    </div>
                </div>
            </div>
            <nav class="mt-4 px-3 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kontrolna tabla</span>
                </a>

                <!-- Website Section -->
                <div class="px-4 mt-6 mb-2 text-xs font-bold text-primary-300 uppercase tracking-wider">
                    Website
                </div>
                <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.services.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.services.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Usluge</span>
                </a>
                <a href="{{ route('admin.product-categories.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.product-categories.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.product-categories.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Kategorije</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Proizvodi</span>
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.inquiries.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.inquiries.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Upiti</span>
                </a>
                <a href="{{ route('admin.homepage-contents.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.homepage-contents.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.homepage-contents.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Sadržaj naslove</span>
                </a>
                
                <!-- Worker Section -->
                <div class="px-4 mt-6 mb-2 text-xs font-bold text-primary-300 uppercase tracking-wider">
                    Radnici & Dozvole
                </div>
                <a href="{{ route('admin.workers.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.workers.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.workers.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex flex-col">
                        <span class="font-medium">Radnici</span>
                        <span class="text-xs text-gray-400">Upravljanje dozvolama</span>
                    </div>
                </a>

                <!-- Settings Section -->
                <div class="px-4 mt-6 mb-2 text-xs font-bold text-primary-300 uppercase tracking-wider">
                    Podešavanja
                </div>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/50' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/15' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Sistemska Podešavanja</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header class="bg-white/70 backdrop-blur-lg shadow-sm border-b border-gray-100">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">@yield('title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500 mt-0.5">{{ now()->locale('sr')->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Website Link -->
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200 group">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span class="hidden sm:inline font-medium">View Site</span>
                        </a>
                        
                        <!-- User Profile -->
                        <div class="flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-primary-50 to-light-50 rounded-xl border border-primary-100">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 text-white font-bold text-sm shadow-lg">
                                {{ substr(Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : 'A', 0, 1) }}
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : '' }}</p>
                                <p class="text-xs text-primary-600 font-medium">Administrator</p>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="hidden sm:inline">Odjavi se</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                <div class="max-w-7xl mx-auto">
                    @if (session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100/50 border-l-4 border-green-500 p-4 rounded-xl shadow-lg flex items-start sm:items-center justify-between animate-fade-in-up">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg mr-3">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-sm text-green-900 font-medium">{{ session('success') }}</p>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 hover:bg-green-200 p-1 rounded-lg transition-all ml-4">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100/50 border-l-4 border-red-500 p-4 rounded-xl shadow-lg flex items-start sm:items-center justify-between animate-fade-in-up">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg mr-3">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-red-900 font-medium">{{ session('error') }}</p>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 hover:bg-red-200 p-1 rounded-lg transition-all ml-4">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
    
    <script>
        // SweetAlert2 confirmation for delete/ban forms
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all forms with data-confirm attribute
            document.querySelectorAll('form[data-confirm]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const message = this.getAttribute('data-confirm');
                    const isDelete = this.getAttribute('data-type') === 'delete';
                    const isBan = this.getAttribute('data-type') === 'ban';
                    
                    Swal.fire({
                        title: 'Da li ste sigurni?',
                        text: message,
                        icon: isDelete ? 'warning' : (isBan ? 'error' : 'question'),
                        showCancelButton: true,
                        confirmButtonColor: isDelete ? '#DD2131' : (isBan ? '#DD2131' : '#09539A'),
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: isDelete ? 'Da, obriši!' : (isBan ? 'Da, banuj!' : 'Da, potvrdi!'),
                        cancelButtonText: 'Otkaži',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                            cancelButton: 'rounded-xl px-6 py-3 font-semibold'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
