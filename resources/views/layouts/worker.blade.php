<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', 'Worker Dashboard') - FTHERM</title>
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
                <a href="{{ route('worker.dashboard') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.dashboard') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Kontrolna tabla</span>
                </a>

                <!-- Production Section -->
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Materijal & Nalozi
                    </div>
                </div>
                <a href="{{ route('worker.products.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.products.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Interni Materijali</span>
                </a>
                
                <a href="{{ route('worker.work-orders.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.work-orders.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Radni Nalozi</span>
                </a>

                <!-- Inventory Section -->
                <div class="px-4 lg:px-6 mt-6 mb-2 section-header">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Inventar & Finansije
                    </div>
                </div>
                <a href="{{ route('worker.inventory.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.inventory.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Dopuna Zaliha</span>
                </a>
                
                <a href="{{ route('worker.invoices.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('worker.invoices.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500 active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Fakture</span>
                </a>
            </nav>
            
            <!-- User Info & Logout at Bottom -->
            <div class="mt-auto p-4 lg:p-6 border-t border-industrial-800">
                <div class="flex items-center gap-2 mb-3 px-2 lg:px-3 py-2 bg-industrial-800 rounded-lg">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-white font-medium text-xs lg:text-sm truncate">{{ Auth::guard('worker')->user() ? Auth::guard('worker')->user()->name : '' }}</span>
                    <span class="text-xs text-gray-400 px-1.5 lg:px-2 py-0.5 bg-industrial-900 rounded ml-auto whitespace-nowrap">Radnik</span>
                </div>
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
            <!-- Mobile Header with Hamburger -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30 lg:hidden">
                <div class="flex items-center justify-between py-3 px-4">
                    <button id="open-sidebar" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-8 w-8">
                    </div>
                    <div class="w-6"></div> <!-- Spacer for centering -->
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
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
            const sidebarLinks = sidebar.querySelectorAll('nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
