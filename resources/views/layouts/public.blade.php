<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>@yield('title', __('frontend.nav_home')) - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white font-sans antialiased" x-data="{ mobileMenu: false }" x-cloak>

    <!-- Mobile Menu Backdrop -->
    <div x-show="mobileMenu" @click="mobileMenu = false" x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
        aria-hidden="true">
    </div>

    <!-- Mobile Drawer -->
    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed top-0 right-0 h-full w-80 max-w-[90vw] bg-white z-50 shadow-2xl flex flex-col lg:hidden"
        @keydown.escape.window="mobileMenu = false">

        <!-- Drawer Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <a href="{{ route('home') }}" @click="mobileMenu = false" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12">
            </a>
            <button @click="mobileMenu = false"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 transition"
                aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Drawer Nav Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
            <a href="{{ route('home') }}" @click="mobileMenu = false"
                class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-base font-semibold transition-all group {{ request()->routeIs('home') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/25' : 'text-gray-700 hover:bg-gray-50 hover:text-primary-700' }}">
                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('home') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-primary-100' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </span>
                {{ __('frontend.nav_home') }}
            </a>
            <a href="{{ route('home') }}#services" @click="mobileMenu = false"
                class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-base font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary-700 transition-all group">
                <span
                    class="w-9 h-9 rounded-xl bg-gray-100 group-hover:bg-primary-100 flex items-center justify-center flex-shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </span>
                {{ __('frontend.nav_services') }}
            </a>
            <a href="{{ route('shop.index') }}" @click="mobileMenu = false"
                class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-base font-semibold transition-all group {{ request()->routeIs('shop.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/25' : 'text-gray-700 hover:bg-gray-50 hover:text-primary-700' }}">
                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('shop.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-primary-100' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>
                {{ __('frontend.nav_products') }}
            </a>
            <a href="{{ route('gallery.index', current_locale()) }}" @click="mobileMenu = false"
                class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-base font-semibold transition-all group {{ request()->routeIs('gallery.*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/25' : 'text-gray-700 hover:bg-gray-50 hover:text-primary-700' }}">
                <span
                    class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 {{ request()->routeIs('gallery.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-primary-100' }} transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
                {{ __('frontend.nav_gallery') }}
            </a>
            <a href="{{ route('home') }}#contact" @click="mobileMenu = false"
                class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-base font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary-700 transition-all group">
                <span
                    class="w-9 h-9 rounded-xl bg-gray-100 group-hover:bg-primary-100 flex items-center justify-center flex-shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                {{ __('frontend.nav_contact') }}
            </a>
        </nav>

        <!-- Drawer Footer -->
        <div class="px-6 pb-8 pt-4 border-t border-gray-100 space-y-4">
            <!-- CTA -->
            <a href="{{ route('home') }}#contact" @click="mobileMenu = false"
                class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-bold px-5 py-3.5 rounded-2xl transition shadow-lg shadow-primary-500/25 group">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ __('frontend.nav_contact') }}
            </a>
            <!-- Language switcher -->
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2.5">Language</p>
                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ change_locale_url('sr') }}"
                        class="flex flex-col items-center gap-1 py-2.5 rounded-xl text-xs font-bold transition {{ current_locale() === 'sr' ? 'bg-primary-600 text-white shadow-md shadow-primary-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <span class="text-xl leading-none">🇷🇸</span> SR
                    </a>
                    <a href="{{ change_locale_url('hu') }}"
                        class="flex flex-col items-center gap-1 py-2.5 rounded-xl text-xs font-bold transition {{ current_locale() === 'hu' ? 'bg-primary-600 text-white shadow-md shadow-primary-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <span class="text-xl leading-none">🇭🇺</span> HU
                    </a>
                    <a href="{{ change_locale_url('en') }}"
                        class="flex flex-col items-center gap-1 py-2.5 rounded-xl text-xs font-bold transition {{ current_locale() === 'en' ? 'bg-primary-600 text-white shadow-md shadow-primary-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <span class="text-xl leading-none">🇬🇧</span> EN
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur-xl border-b border-gray-100/80 sticky top-0 z-30 shadow-sm">
        <!-- Accent line at top -->
        <div class="h-0.5 bg-gradient-to-r from-primary-600 via-primary-400 to-primary-600"></div>

        <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
            <div class="flex items-center justify-between h-18" style="height:72px">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                    <div class="relative">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo"
                            class="h-14 transition-transform duration-300 group-hover:scale-110">
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 group {{ request()->routeIs('home') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-700' }}">
                        {{ __('frontend.nav_home') }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-primary-500 rounded-full transition-all duration-200 {{ request()->routeIs('home') ? 'w-5' : 'w-0 group-hover:w-5' }}"></span>
                    </a>
                    <a href="{{ route('home') }}#services"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-primary-700 transition-all duration-200 group">
                        {{ __('frontend.nav_services') }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-primary-500 rounded-full transition-all duration-200 w-0 group-hover:w-5"></span>
                    </a>
                    <a href="{{ route('shop.index') }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 group {{ request()->routeIs('shop.*') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-700' }}">
                        {{ __('frontend.nav_products') }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-primary-500 rounded-full transition-all duration-200 {{ request()->routeIs('shop.*') ? 'w-5' : 'w-0 group-hover:w-5' }}"></span>
                    </a>
                    <a href="{{ route('gallery.index', current_locale()) }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 group {{ request()->routeIs('gallery.*') ? 'text-primary-700' : 'text-gray-600 hover:text-primary-700' }}">
                        {{ __('frontend.nav_gallery') }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-primary-500 rounded-full transition-all duration-200 {{ request()->routeIs('gallery.*') ? 'w-5' : 'w-0 group-hover:w-5' }}"></span>
                    </a>
                    <a href="{{ route('home') }}#contact"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-primary-700 transition-all duration-200 group">
                        {{ __('frontend.nav_contact') }}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-primary-500 rounded-full transition-all duration-200 w-0 group-hover:w-5"></span>
                    </a>
                </div>

                <!-- Right: Language + CTA + Hamburger -->
                <div class="flex items-center gap-2 sm:gap-3">

                    <!-- Language Switcher Dropdown -->
                    <div class="relative hidden sm:block" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:text-primary-700 hover:bg-gray-50 transition-all duration-200 border border-gray-200 hover:border-primary-200 bg-white select-none">
                            <span class="text-base leading-none">
                                @if (current_locale() === 'sr')
                                    🇷🇸
                                @elseif(current_locale() === 'hu')
                                    🇭🇺
                                @else
                                    🇬🇧
                                @endif
                            </span>
                            <span class="font-bold tracking-wide">{{ strtoupper(current_locale()) }}</span>
                            <svg class="w-3 h-3 text-gray-400 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-xl shadow-gray-200/80 border border-gray-100 overflow-hidden z-50 py-1"
                            @click="open = false">
                            <a href="{{ change_locale_url('sr') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors {{ current_locale() === 'sr' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="text-base">🇷🇸</span>
                                <span>Srpski</span>
                                @if (current_locale() === 'sr')
                                    <svg class="w-3.5 h-3.5 ml-auto text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                            <a href="{{ change_locale_url('hu') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors {{ current_locale() === 'hu' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="text-base">🇭🇺</span>
                                <span>Magyar</span>
                                @if (current_locale() === 'hu')
                                    <svg class="w-3.5 h-3.5 ml-auto text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                            <a href="{{ change_locale_url('en') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold transition-colors {{ current_locale() === 'en' ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="text-base">🇬🇧</span>
                                <span>English</span>
                                @if (current_locale() === 'en')
                                    <svg class="w-3.5 h-3.5 ml-auto text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- CTA Button (Desktop) -->
                    <a href="{{ route('home') }}#contact"
                        class="hidden lg:inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-primary-500/20 hover:shadow-lg hover:shadow-primary-500/30 hover:-translate-y-px">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('frontend.nav_contact') }}
                    </a>

                    <!-- Hamburger Button (animated) -->
                    <button @click="mobileMenu = !mobileMenu"
                        class="lg:hidden relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-600 hover:text-primary-700 hover:bg-gray-100 transition-colors duration-200 focus:outline-none"
                        aria-label="Toggle menu" :aria-expanded="mobileMenu">
                        <span class="sr-only">Menu</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Bar 1 -->
                            <line x1="3" y1="6" x2="21" y2="6" stroke-width="2"
                                stroke-linecap="round"
                                :style="mobileMenu ?
                                    'transform:rotate(45deg) translateY(6px);transform-origin:center;transition:transform 0.25s' :
                                    'transition:transform 0.25s'" />
                            <!-- Bar 2 -->
                            <line x1="3" y1="12" x2="21" y2="12" stroke-width="2"
                                stroke-linecap="round"
                                :style="mobileMenu ? 'opacity:0;transition:opacity 0.15s' : 'opacity:1;transition:opacity 0.15s'" />
                            <!-- Bar 3 -->
                            <line x1="3" y1="18" x2="21" y2="18" stroke-width="2"
                                stroke-linecap="round"
                                :style="mobileMenu ?
                                    'transform:rotate(-45deg) translateY(-6px);transform-origin:center;transition:transform 0.25s' :
                                    'transition:transform 0.25s'" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-industrial-900 text-white relative overflow-hidden">
        <!-- Top accent line -->
        <div class="h-1 bg-gradient-to-r from-primary-700 via-primary-400 to-secondary-600"></div>

        <!-- Ambient background glow -->
        <div class="absolute inset-0 pointer-events-none select-none">
            <div class="absolute -top-40 -right-40 w-[28rem] h-[28rem] bg-primary-600/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[28rem] h-[28rem] bg-secondary-600/5 rounded-full blur-3xl">
            </div>
        </div>

        <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10">
            <!-- Main Footer Grid -->
            <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                <!-- Brand Column -->
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5 group">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-16">
                    </a>
                    <p class="text-industrial-400 leading-relaxed text-sm mb-7">
                        {{ __('frontend.footer_description') }}
                    </p>
                    <a href="{{ route('home') }}#contact"
                        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-lg shadow-primary-900/50 group">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('frontend.nav_contact') }}
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform flex-shrink-0"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3
                        class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-6 flex items-center gap-2.5">
                        <span class="w-5 h-px bg-primary-400 inline-block"></span>
                        {{ __('frontend.footer_quick_links') }}
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('home') }}"
                                class="text-industrial-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2.5 group py-1.5">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>
                                {{ __('frontend.nav_home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#services"
                                class="text-industrial-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2.5 group py-1.5">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>
                                {{ __('frontend.nav_services') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.index') }}"
                                class="text-industrial-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2.5 group py-1.5">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>
                                {{ __('frontend.nav_products') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery.index', current_locale()) }}"
                                class="text-industrial-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2.5 group py-1.5">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>
                                {{ __('frontend.nav_gallery') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#contact"
                                class="text-industrial-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2.5 group py-1.5">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-primary-700 group-hover:bg-primary-400 transition-colors flex-shrink-0"></span>
                                {{ __('frontend.nav_contact') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3
                        class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-6 flex items-center gap-2.5">
                        <span class="w-5 h-px bg-primary-400 inline-block"></span>
                        {{ __('frontend.footer_contact') }}
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 bg-primary-600/20 rounded-xl flex items-center justify-center flex-shrink-0 ring-1 ring-primary-500/20">
                                <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-industrial-500 font-medium mb-0.5">
                                    {{ __('frontend.contact_phone_label') }}</p>
                                <a href="tel:0641391360"
                                    class="text-white hover:text-primary-300 text-sm font-medium transition-colors">064
                                    139 1360</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="w-9 h-9 bg-secondary-600/20 rounded-xl flex items-center justify-center flex-shrink-0 ring-1 ring-secondary-500/20">
                                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-industrial-500 font-medium mb-0.5">
                                    {{ __('frontend.contact_email_label') }}</p>
                                <a href="mailto:farkas.tibor@ftherm.rs"
                                    class="text-white hover:text-primary-300 text-sm font-medium transition-colors break-all">farkas.tibor@ftherm.rs</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Business Hours -->
                <div>
                    <h3
                        class="text-xs font-bold uppercase tracking-widest text-primary-400 mb-6 flex items-center gap-2.5">
                        <span class="w-5 h-px bg-primary-400 inline-block"></span>
                        {{ __('frontend.contact_hours_title') }}
                    </h3>
                    <ul class="divide-y divide-industrial-800">
                        <li class="flex items-center justify-between py-2.5 text-sm">
                            <span class="text-industrial-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 flex-shrink-0"></span>
                                {{ __('frontend.contact_weekdays') }}
                            </span>
                            <span
                                class="text-white font-semibold text-xs bg-primary-600/20 ring-1 ring-primary-600/30 px-2 py-0.5 rounded-lg">08:00
                                – 18:00</span>
                        </li>
                        <li class="flex items-center justify-between py-2.5 text-sm">
                            <span class="text-industrial-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 flex-shrink-0"></span>
                                {{ __('frontend.contact_saturday') }}
                            </span>
                            <span
                                class="text-white font-semibold text-xs bg-primary-600/20 ring-1 ring-primary-600/30 px-2 py-0.5 rounded-lg">09:00
                                – 14:00</span>
                        </li>
                        <li class="flex items-center justify-between py-2.5 text-sm">
                            <span class="text-industrial-400 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary-500 flex-shrink-0"></span>
                                {{ __('frontend.contact_sunday') }}
                            </span>
                            <span
                                class="text-secondary-400 font-semibold text-xs bg-secondary-600/10 ring-1 ring-secondary-700/30 px-2 py-0.5 rounded-lg">{{ __('frontend.contact_closed') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div
                class="border-t border-industrial-800 py-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-industrial-500 text-xs">
                    &copy; {{ date('Y') }} <span class="font-bold text-industrial-300">FTherm</span>.
                    {{ __('frontend.footer_rights') }}
                </p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
