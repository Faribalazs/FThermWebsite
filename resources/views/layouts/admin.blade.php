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
    <title>@yield('title', 'Admin Dashboard') - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @supports (padding: max(0px)) {
            body { padding-top: env(safe-area-inset-top); padding-bottom: env(safe-area-inset-bottom); }
            .mobile-bottom-nav { padding-bottom: calc(env(safe-area-inset-bottom) + 0.5rem); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-hidden">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-industrial-900 text-white flex-shrink-0 fixed h-screen overflow-y-auto z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Close Button (Mobile Only) -->
            <button id="close-sidebar" class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-4 lg:p-6 lg:pb-2">
                <div class="flex items-center gap-2 lg:gap-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-20 lg:h-20 lg:w-32">
                </div>
                <p class="text-xs text-primary-300 font-semibold mt-1 ml-1">Admin Panel</p>
            </div>

            <nav class="mt-4 lg:mt-6 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Kontrolna tabla</span>
                </a>

                <div class="px-4 lg:px-6 mt-6 mb-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Website</div>
                </div>

                <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.services.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Usluge</span>
                </a>

                <a href="{{ route('admin.product-categories.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.product-categories.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Kategorije</span>
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.products.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Proizvodi</span>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.inquiries.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Upiti</span>
                </a>

                <a href="{{ route('admin.homepage-contents.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.homepage-contents.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Sadržaj naslove</span>
                </a>

                <div class="px-4 lg:px-6 mt-6 mb-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Radnici & Dozvole</div>
                </div>

                <a href="{{ route('admin.workers.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.workers.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Radnici</span>
                </a>

                <div class="px-4 lg:px-6 mt-6 mb-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Podešavanja</div>
                </div>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 lg:px-6 py-3 text-gray-300 hover:bg-industrial-800 hover:text-white transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-industrial-800 text-white border-l-4 border-primary-500' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm lg:text-base">Sistemska Podešavanja</span>
                </a>
            </nav>

            <!-- User Info & Logout at Bottom -->
            <div class="mt-auto p-4 lg:p-6 border-t border-industrial-800">
                <div class="flex items-center gap-2 mb-3 px-2 lg:px-3 py-2 bg-industrial-800 rounded-lg">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-white font-medium text-xs lg:text-sm truncate">{{ Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : '' }}</span>
                </div>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-1 flex-1 px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-industrial-700 rounded-lg transition-all justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span class="text-xs">Sajt</span>
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-red-600 rounded-lg transition-all justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-xs">Odjavi se</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full lg:ml-64 overflow-x-hidden">
            <!-- Mobile Header -->
            <header class="bg-white border-b border-gray-100 sticky top-0 z-30 lg:hidden shadow-sm">
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/logo.svg') }}" alt="FTHERM" class="h-8 w-auto">
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <p class="text-xs font-semibold text-gray-900 leading-tight">{{ Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : '' }}</p>
                                <p class="text-[10px] text-primary-600 font-medium">Administrator</p>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                {{ substr(Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : 'A', 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-50 pb-20 lg:pb-0">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="w-full">
                        @if (session('success'))
                            <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-green-100/50 border-l-4 border-green-500 p-3 sm:p-4 rounded-xl shadow-lg flex items-center justify-between animate-fade-in-up">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg mr-3">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm text-green-900 font-medium">{{ session('success') }}</p>
                                </div>
                                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 hover:bg-green-200 p-1 rounded-lg transition-all ml-4 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 sm:mb-6 bg-gradient-to-r from-red-50 to-red-100/50 border-l-4 border-red-500 p-3 sm:p-4 rounded-xl shadow-lg flex items-center justify-between animate-fade-in-up">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg mr-3">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm text-red-900 font-medium">{{ session('error') }}</p>
                                </div>
                                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 hover:bg-red-200 p-1 rounded-lg transition-all ml-4 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Mobile Bottom Navigation -->
            <nav class="mobile-bottom-nav fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 lg:hidden z-40 shadow-lg">
                <div class="grid grid-cols-5 h-16">
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-xs font-medium">Početna</span>
                        @if(request()->routeIs('admin.dashboard'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('admin.products.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-xs font-medium">Proizvodi</span>
                        @if(request()->routeIs('admin.products.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.inquiries.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('admin.inquiries.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-medium">Upiti</span>
                        @if(request()->routeIs('admin.inquiries.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.workers.index') }}" class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('admin.workers.*') ? 'text-primary-600' : 'text-gray-500' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-xs font-medium">Radnici</span>
                        @if(request()->routeIs('admin.workers.*'))
                        <div class="absolute bottom-0 w-12 h-0.5 bg-primary-600 rounded-t-full"></div>
                        @endif
                    </a>

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
                    <div class="flex justify-center pt-3 pb-2">
                        <div class="w-12 h-1 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="px-4 py-2 pb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Meni</h3>
                            <button id="mobile-more-menu-close" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-1 max-h-96 overflow-y-auto">
                            <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('admin.services.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="font-medium">Usluge</span>
                            </a>
                            <a href="{{ route('admin.product-categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.product-categories.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('admin.product-categories.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <span class="font-medium">Kategorije</span>
                            </a>
                            <a href="{{ route('admin.homepage-contents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.homepage-contents.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('admin.homepage-contents.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <span class="font-medium">Sadržaj naslove</span>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700' }}">
                                <div class="w-10 h-10 rounded-full {{ request()->routeIs('admin.settings.*') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="font-medium">Podešavanja</span>
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-gray-700">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </div>
                                <span class="font-medium">Pogledaj sajt</span>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}" class="mt-4 pt-4 border-t border-gray-200">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 transition-colors text-red-600 w-full">
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const closeBtn = document.getElementById('close-sidebar');

            function closeSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);
            if (sidebar) {
                sidebar.querySelectorAll('nav a').forEach(link => {
                    link.addEventListener('click', function() { if (window.innerWidth < 1024) closeSidebar(); });
                });
            }

            // Mobile More Menu
            const moreMenuBtn = document.getElementById('mobile-more-menu-btn');
            const moreMenu = document.getElementById('mobile-more-menu');
            const moreMenuContent = document.getElementById('mobile-more-menu-content');
            const moreMenuClose = document.getElementById('mobile-more-menu-close');

            function openMoreMenu() {
                if (moreMenu && moreMenuContent) {
                    moreMenu.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    setTimeout(() => { moreMenuContent.style.transform = 'translateY(0)'; }, 10);
                }
            }
            function closeMoreMenu() {
                if (moreMenu && moreMenuContent) {
                    moreMenuContent.style.transform = 'translateY(100%)';
                    setTimeout(() => { moreMenu.classList.add('hidden'); document.body.style.overflow = ''; }, 300);
                }
            }
            if (moreMenuBtn) moreMenuBtn.addEventListener('click', openMoreMenu);
            if (moreMenuClose) moreMenuClose.addEventListener('click', closeMoreMenu);
            if (moreMenu) moreMenu.addEventListener('click', function(e) { if (e.target === moreMenu) closeMoreMenu(); });
            if (moreMenuContent) {
                moreMenuContent.querySelectorAll('a').forEach(link => { link.addEventListener('click', closeMoreMenu); });
                let startY = 0;
                moreMenuContent.addEventListener('touchstart', function(e) { startY = e.touches[0].clientY; }, { passive: true });
                moreMenuContent.addEventListener('touchmove', function(e) { const d = e.touches[0].clientY - startY; if (d > 0) moreMenuContent.style.transform = `translateY(${d}px)`; }, { passive: true });
                moreMenuContent.addEventListener('touchend', function(e) { if (e.changedTouches[0].clientY - startY > 100) closeMoreMenu(); else moreMenuContent.style.transform = 'translateY(0)'; }, { passive: true });
            }

            // SweetAlert2 confirmation for delete/ban forms
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
                        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-6 py-3 font-semibold', cancelButton: 'rounded-xl px-6 py-3 font-semibold' }
                    }).then((result) => { if (result.isConfirmed) this.submit(); });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
