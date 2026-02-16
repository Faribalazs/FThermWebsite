<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Worker Dashboard') - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-industrial-900 text-white flex-shrink-0 fixed h-screen overflow-y-auto custom-scrollbar z-30">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-primary-400">FTHERM Worker</h1>
                <p class="text-xs text-gray-400 mt-1">Radnički Panel</p>
            </div>
            <nav class="mt-6 sidebar-nav">
                <a href="{{ route('worker.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.dashboard') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kontrolna tabla
                </a>
                
                <a href="{{ route('worker.products.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.products.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Interni Proizvodi
                </a>
                
                <a href="{{ route('worker.work-orders.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.work-orders.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Radni Nalozi
                </a>
                
                <a href="{{ route('worker.inventory.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.inventory.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Dopuna Zaliha
                </a>
                
                <a href="{{ route('worker.invoices.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.invoices.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Fakture
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
                <div class="flex justify-between items-center py-4 px-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('header', 'Dashboard')
                    </h2>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 px-3 py-2 bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-gray-700 font-medium">{{ Auth::guard('worker')->user() ? Auth::guard('worker')->user()->name : '' }}</span>
                            <span class="text-xs text-gray-500 px-2 py-0.5 bg-white rounded">Radnik</span>
                        </div>
                        <form method="POST" action="{{ route('worker.logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Odjavi se
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
