<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', 'Worker Dashboard') - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* iOS Safe Area Support */
        @supports (padding: max(0px)) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }
            .mobile-bottom-nav {
                padding-bottom: calc(env(safe-area-inset-bottom) + 0.5rem);
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-hidden">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
    
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-industrial-900 text-white flex-shrink-0 fixed h-screen overflow-y-auto custom-scrollbar z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Close Button (Mobile Only) -->
            <button id="close-sidebar" class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="p-4 lg:p-6 lg:pb-2 border-b border-industrial-800/50">
                <div class="flex items-center gap-2 lg:gap-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-20 lg:h-20 lg:w-32">
                </div>
            </div>
            <nav class="mt-4 lg:mt-6 sidebar-nav flex-1">
                <!-- Dashboard -->
                @if(Auth::guard('worker')->user()->hasPermission('dashboard'))
                <a href="{{ route('worker.dashboard') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.dashboard') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Kontrolna tabla</span>
                </a>
                @endif

                <!-- Production Section -->
                @if(Auth::guard('worker')->user()->hasPermission('products') || Auth::guard('worker')->user()->hasPermission('work_orders'))
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Materijal & Nalozi
                    </div>
                </div>
                @endif
                
                @if(Auth::guard('worker')->user()->hasPermission('products'))
                <a href="{{ route('worker.products.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.products.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Interni Materijali</span>
                </a>
                @endif
                
                @if(Auth::guard('worker')->user()->hasPermission('work_orders'))
                <a href="{{ route('worker.work-orders.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.work-orders.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Radni Nalozi</span>
                </a>
                @endif

                @if(Auth::guard('worker')->user()->hasPermission('ponude'))
                <a href="{{ route('worker.ponude.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.ponude.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Ponude</span>
                </a>
                @endif

                <!-- Inventory Section -->
                @if(Auth::guard('worker')->user()->hasPermission('inventory') || Auth::guard('worker')->user()->hasPermission('invoices'))
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Inventar & Finansije
                    </div>
                </div>
                @endif
                
                @if(Auth::guard('worker')->user()->hasPermission('inventory'))
                <a href="{{ route('worker.inventory.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.inventory.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Dopuna Zaliha</span>
                </a>
                
                <a href="{{ route('worker.warehouses.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.warehouses.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Skladišta</span>
                </a>
                @endif
                
                @if(Auth::guard('worker')->user()->hasPermission('invoices'))
                <a href="{{ route('worker.invoices.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.invoices.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Fakture</span>
                </a>
                @endif

                <!-- Activity Logs Section -->
                @if(Auth::guard('worker')->user()->hasPermission('activity_logs'))
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Sistem
                    </div>
                </div>
                
                <a href="{{ route('worker.activity-logs.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.activity-logs.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Dnevnik Aktivnosti</span>
                </a>
                @endif

                <!-- Settings (available to all workers) -->
                @if(!Auth::guard('worker')->user()->hasPermission('activity_logs'))
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Sistem
                    </div>
                </div>
                @endif
                
                <a href="{{ route('worker.settings.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.settings.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Podešavanja</span>
                </a>
            </nav>
            
            <!-- User Info & Logout at Bottom -->
            <div class="mt-auto p-4 lg:p-6 border-t border-industrial-800">
                <div class="flex items-center gap-2 mb-3 px-2 lg:px-3 py-2 bg-industrial-800 rounded-lg">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-white font-medium text-xs lg:text-sm truncate">{{ Auth::guard('worker')->user() ? Auth::guard('worker')->user()->name : '' }}</span>                </div>
                <form method="POST" action="{{ route('worker.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 w-full px-3 lg:px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-red-600 rounded-lg transition-all">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="text-sm">Odjavi se</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full lg:ml-64 overflow-x-hidden">
            <!-- Modern Mobile Header -->
            <header class="mobile-header bg-white border-b border-gray-100 sticky top-0 z-30 lg:hidden shadow-sm">
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <!-- Logo -->
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/logo.svg') }}" alt="FTHERM" class="h-8 w-auto">
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <p class="text-xs font-semibold text-gray-900 leading-tight">{{ Auth::guard('worker')->user() ? Auth::guard('worker')->user()->name : '' }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                {{ substr(Auth::guard('worker')->user() ? Auth::guard('worker')->user()->name : '', 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area with Bottom Nav Padding -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar bg-gray-50 pb-20 lg:pb-0">
                @yield('content')
            </main>

            <!-- Modern Mobile Bottom Navigation -->
            <nav class="mobile-bottom-nav fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 lg:hidden z-40 shadow-lg">
                <div class="grid grid-cols-5 h-16">
                    <!-- Dashboard -->
                    @if(Auth::guard('worker')->user()->hasPermission('dashboard'))
                    <a href="{{ route('worker.dashboard') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('worker.dashboard') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-xs font-medium">Početna</span>
                        @if(request()->routeIs('worker.dashboard'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>
                    @endif

                    <!-- Products -->
                    @if(Auth::guard('worker')->user()->hasPermission('products'))
                    <a href="{{ route('worker.products.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('worker.products.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-xs font-medium">Materijal</span>
                        @if(request()->routeIs('worker.products.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>
                    @endif

                    <!-- Work Orders -->
                    @if(Auth::guard('worker')->user()->hasPermission('work_orders'))
                    <a href="{{ route('worker.work-orders.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('worker.work-orders.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs font-medium">Nalozi</span>
                        @if(request()->routeIs('worker.work-orders.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>
                    @endif

                    <!-- Inventory -->
                    @if(Auth::guard('worker')->user()->hasPermission('inventory'))
                    <a href="{{ route('worker.inventory.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('worker.inventory.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <span class="text-xs font-medium">Zalihe</span>
                        @if(request()->routeIs('worker.inventory.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>
                    @endif

                    <!-- More Menu -->
                    <button id="mobile-more-menu-btn" class="flex flex-col items-center justify-center gap-1 transition-all text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="text-xs font-medium">Više</span>
                    </button>
                </div>
            </nav>

            <!-- Mobile More Menu Modal -->
            <div id="mobile-more-menu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden" style="backdrop-filter: blur(4px);">
                <div class="absolute inset-x-0 bottom-0 bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-300" id="mobile-more-menu-content">
                    <!-- Handle Bar -->
                    <div class="flex justify-center pt-3 pb-2">
                        <div class="w-12 h-1 bg-gray-300 rounded-full"></div>
                    </div>
                    
                    <div class="px-4 py-2 pb-8">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Meni</h3>
                            <button id="mobile-more-menu-close" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Menu Items -->
                        <div class="space-y-1 max-h-96 overflow-y-auto">
                            @if(Auth::guard('worker')->user()->hasPermission('ponude'))
                            <a href="{{ route('worker.ponude.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('worker.ponude.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('worker.ponude.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Ponude</span>
                            </a>
                            @endif

                            @if(Auth::guard('worker')->user()->hasPermission('invoices'))
                            <a href="{{ route('worker.invoices.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('worker.invoices.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('worker.invoices.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Fakture</span>
                            </a>
                            @endif

                            @if(Auth::guard('worker')->user()->hasPermission('activity_logs'))
                            <a href="{{ route('worker.activity-logs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('worker.activity-logs.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('worker.activity-logs.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Dnevnik Aktivnosti</span>
                            </a>
                            @endif

                            <!-- Settings -->
                            <a href="{{ route('worker.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('worker.settings.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('worker.settings.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Podešavanja</span>
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('worker.logout') }}" class="mt-4 pt-4 border-t border-gray-200">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 transition-colors text-red-600 w-full">
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Odjavi se</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Desktop Sidebar functionality
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            // Desktop sidebar functions (still needed for tablet/desktop)
            function openSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }

            if (openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on a link (mobile only)
            if (sidebar) {
                const sidebarLinks = sidebar.querySelectorAll('nav a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 1024) {
                            closeSidebar();
                        }
                    });
                });
            }

            // Mobile More Menu Modal functionality
            const moreMenuBtn = document.getElementById('mobile-more-menu-btn');
            const moreMenu = document.getElementById('mobile-more-menu');
            const moreMenuContent = document.getElementById('mobile-more-menu-content');
            const moreMenuClose = document.getElementById('mobile-more-menu-close');

            function openMoreMenu() {
                if (moreMenu && moreMenuContent) {
                    moreMenu.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    // Trigger animation
                    setTimeout(() => {
                        moreMenuContent.style.transform = 'translateY(0)';
                    }, 10);
                }
            }

            function closeMoreMenu() {
                if (moreMenu && moreMenuContent) {
                    moreMenuContent.style.transform = 'translateY(100%)';
                    setTimeout(() => {
                        moreMenu.classList.add('hidden');
                        document.body.style.overflow = '';
                    }, 300);
                }
            }

            if (moreMenuBtn) {
                moreMenuBtn.addEventListener('click', openMoreMenu);
            }

            if (moreMenuClose) {
                moreMenuClose.addEventListener('click', closeMoreMenu);
            }

            // Close more menu when clicking outside content
            if (moreMenu) {
                moreMenu.addEventListener('click', function(e) {
                    if (e.target === moreMenu) {
                        closeMoreMenu();
                    }
                });
            }

            // Close more menu when clicking on a link
            if (moreMenuContent) {
                const moreMenuLinks = moreMenuContent.querySelectorAll('a');
                moreMenuLinks.forEach(link => {
                    link.addEventListener('click', closeMoreMenu);
                });
            }

            // Handle swipe down to close
            let startY = 0;
            if (moreMenuContent) {
                moreMenuContent.addEventListener('touchstart', function(e) {
                    startY = e.touches[0].clientY;
                }, { passive: true });

                moreMenuContent.addEventListener('touchmove', function(e) {
                    const currentY = e.touches[0].clientY;
                    const diff = currentY - startY;
                    
                    if (diff > 0) {
                        moreMenuContent.style.transform = `translateY(${diff}px)`;
                    }
                }, { passive: true });

                moreMenuContent.addEventListener('touchend', function(e) {
                    const currentY = e.changedTouches[0].clientY;
                    const diff = currentY - startY;
                    
                    if (diff > 100) {
                        closeMoreMenu();
                    } else {
                        moreMenuContent.style.transform = 'translateY(0)';
                    }
                }, { passive: true });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
