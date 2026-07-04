<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

@php
    $supportedLocales = ['hu' => 'HU', 'sr' => 'SR', 'en' => 'EN'];
    $localeNames = ['hu' => 'Magyar', 'sr' => 'Srpski', 'en' => 'English'];
    $localeFlags = ['hu' => '🇭🇺', 'sr' => '🇷🇸', 'en' => '🇬🇧'];
    $currentLocale = current_locale();
    $shopEnabled = shop_enabled();
    $companyPhone = setting_value('company_phone');
    $companyEmail = setting_value('company_email');
    $companyAddress = setting_value('company_address');
    $telHref = $companyPhone ? 'tel:' . preg_replace('/[^\d+]/', '', $companyPhone) : null;
    $pageTitle = trim($__env->yieldContent('title')) ?: 'FTHERM';
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: __('ftherm.seo.meta_description');
    $metaKeywords = trim($__env->yieldContent('meta_keywords')) ?: __('ftherm.seo.keywords');
    $canonicalUrl = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @foreach ($supportedLocales as $locale => $label)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ change_locale_url($locale) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ change_locale_url('sr') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ $pageTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        .site-topbar {
            position: relative;
            z-index: 45;
        }

        .site-header {
            padding: 0.85rem clamp(0.75rem, 2.5vw, 2rem);
            margin-bottom: calc(-5rem - 1.7rem);
            background: transparent;
            pointer-events: none;
        }

        .site-header::after {
            display: none;
        }

        .site-nav-shell {
            position: relative;
            isolation: isolate;
            overflow: visible;
            pointer-events: auto;
            border-radius: 2rem;
            border: 0;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.92), rgba(245, 250, 255, 0.74) 46%, rgba(224, 241, 255, 0.62)),
                rgba(255, 255, 255, 0.78);
            box-shadow:
                0 18px 42px rgba(7, 21, 39, 0.22),
                0 5px 14px rgba(7, 21, 39, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(9, 83, 154, 0.08);
            backdrop-filter: blur(24px) saturate(1.32);
            -webkit-backdrop-filter: blur(24px) saturate(1.32);
        }

        .site-nav-shell::after {
            content: "";
            position: absolute;
            z-index: -1;
            left: 8%;
            right: 8%;
            bottom: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(9, 83, 154, 0.28), rgba(221, 33, 49, 0.22), transparent);
            pointer-events: none;
        }

        .site-nav-link {
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0;
            transition: color 0.2s ease, background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .site-nav-link:hover {
            transform: translateY(-1px);
            box-shadow: inset 0 0 0 1px rgba(9, 83, 154, 0.08);
        }

        .site-action,
        .site-icon-button,
        .site-lang-button {
            border-radius: 999px;
        }

        .site-lang-menu {
            z-index: 90;
            border-radius: 1rem;
        }

        .site-flag {
            display: inline-block;
            font-size: 0.88rem;
            line-height: 1;
        }

        .site-lang-option {
            transition: background 0.18s ease, color 0.18s ease;
        }

        .site-mobile-nav-link {
            text-transform: uppercase;
            letter-spacing: 0;
        }

        .site-footer {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            background:
                radial-gradient(circle at 14% 18%, rgba(12, 147, 234, 0.24), transparent 32%),
                radial-gradient(circle at 86% 22%, rgba(221, 33, 49, 0.16), transparent 28%),
                linear-gradient(135deg, #071527 0%, #08192e 48%, #020617 100%);
        }

        .site-footer::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0.72) 54%, transparent 100%);
            pointer-events: none;
        }

        .footer-panel {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.065);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(18px);
        }

        .footer-link {
            transition: color 0.18s ease, transform 0.18s ease;
        }

        .footer-link:hover {
            transform: translateX(3px);
        }

        .footer-action {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.07);
            transition: border-color 0.18s ease, background 0.18s ease, transform 0.18s ease;
        }

        .footer-action:hover {
            transform: translateY(-2px);
            border-color: rgba(103, 232, 249, 0.36);
            background: rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 767px) {
            .site-header {
                margin-bottom: calc(-5rem - 1.7rem);
            }

            .site-nav-shell {
                border-radius: 1.45rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    @stack('head')
</head>

<body class="bg-white font-sans antialiased text-slate-900" x-data="{ mobileMenu: false, languageOpen: false }">
    <div class="site-topbar bg-slate-950 text-white">
        <div class="mx-auto flex max-w-[1440px] flex-col gap-2 px-4 py-2 text-xs sm:flex-row sm:items-center sm:justify-between lg:px-10">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-slate-300">
                @if ($companyPhone)
                    <a href="{{ $telHref }}" class="inline-flex items-center gap-1.5 hover:text-white">
                        <svg class="h-3.5 w-3.5 text-[#DD2131]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                        </svg>
                        {{ $companyPhone }}
                    </a>
                @endif
                @if ($companyEmail)
                    <a href="mailto:{{ $companyEmail }}" class="inline-flex items-center gap-1.5 hover:text-white">
                        <svg class="h-3.5 w-3.5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $companyEmail }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <header class="site-header sticky top-0 z-40">
        <nav class="site-nav-shell mx-auto flex min-h-20 max-w-[1440px] items-center justify-between px-4 lg:px-10" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="FTHERM">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-14 w-auto">
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.home') }}</a>
                <a href="{{ route('home') }}#services" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.services') }}</a>
                @if ($shopEnabled)
                    <a href="{{ route('shop.index') }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.products') }}</a>
                @endif
                <a href="{{ route('about', ['locale' => current_locale()]) }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.about') }}</a>
                <a href="{{ route('home') }}#references" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.references') }}</a>
                <a href="{{ route('home') }}#faq" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.faq') }}</a>
                <a href="{{ route('home') }}#contact" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.contact') }}</a>
            </div>

            <div class="flex items-center gap-2">
                <div class="relative hidden sm:block" @click.outside="languageOpen = false">
                    <button type="button" @click="languageOpen = !languageOpen" class="site-lang-button inline-flex items-center gap-2 border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:border-sky-200 hover:bg-sky-50" aria-haspopup="true" :aria-expanded="languageOpen.toString()">
                        <span class="site-flag">{{ $localeFlags[$currentLocale] ?? '🌐' }}</span>
                        <span>{{ $supportedLocales[$currentLocale] ?? strtoupper($currentLocale) }}</span>
                        <svg class="h-4 w-4 transition" :class="languageOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-cloak x-show="languageOpen" x-transition class="site-lang-menu absolute right-0 mt-2 w-48 overflow-hidden border border-slate-200 bg-white py-1 shadow-lg">
                        @foreach ($supportedLocales as $locale => $label)
                            <a href="{{ change_locale_url($locale) }}" class="site-lang-option flex items-center gap-3 px-3 py-2 text-sm font-semibold {{ $currentLocale === $locale ? 'bg-sky-50 text-sky-700' : 'text-slate-700 hover:bg-slate-50' }}">
                                <span class="site-flag">{{ $localeFlags[$locale] }}</span>
                                <span class="min-w-0 flex-1">{{ $localeNames[$locale] }}</span>
                                <span class="text-xs font-black">{{ $label }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @if ($companyPhone)
                    <a href="{{ $telHref }}" class="site-action hidden items-center gap-2 bg-slate-950 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700 md:inline-flex">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                        </svg>
                        {{ __('ftherm.cta.call') }}
                    </a>
                @endif
                <button type="button" @click="mobileMenu = true" class="site-icon-button inline-flex h-11 w-11 items-center justify-center border border-slate-200 text-slate-700 lg:hidden" aria-label="Open menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <div x-cloak x-show="mobileMenu" class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-950/60" @click="mobileMenu = false"></div>
        <div x-show="mobileMenu" x-transition class="absolute right-0 top-0 flex h-full w-80 max-w-[88vw] flex-col overflow-hidden rounded-l-[2rem] bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-auto">
                <button type="button" @click="mobileMenu = false" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-700" aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto px-5 py-5">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.home') }}</a>
                    <a href="{{ route('home') }}#services" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.services') }}</a>
                    @if ($shopEnabled)
                        <a href="{{ route('shop.index') }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.products') }}</a>
                    @endif
                    <a href="{{ route('about', ['locale' => current_locale()]) }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.about') }}</a>
                    <a href="{{ route('home') }}#references" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.references') }}</a>
                    <a href="{{ route('home') }}#faq" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.faq') }}</a>
                    <a href="{{ route('home') }}#contact" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.contact') }}</a>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-2">
                    @foreach ($supportedLocales as $locale => $label)
                        <a href="{{ change_locale_url($locale) }}" class="rounded-full border px-2 py-2 text-center text-sm font-bold {{ $currentLocale === $locale ? 'border-sky-700 bg-sky-700 text-white' : 'border-slate-200 text-slate-700' }}">
                            <span class="block text-base leading-none">{{ $localeFlags[$locale] }}</span>
                            <span class="mt-1 block">{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            @if ($companyPhone)
                <div class="space-y-3 border-t border-slate-200 p-5">
                    <a href="{{ $telHref }}" class="flex items-center justify-center gap-2 rounded-full bg-slate-950 px-4 py-3 font-bold text-white">
                        {{ __('ftherm.cta.call') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer text-white">
        <div class="h-1 bg-gradient-to-r from-[#09539A] via-cyan-300 to-[#DD2131]"></div>
        <div class="mx-auto max-w-[1440px] px-4 py-12 lg:px-10 lg:py-16">
            <div class="grid gap-6 lg:grid-cols-[1.15fr_0.9fr_0.9fr_1.05fr]">
                <div class="footer-panel rounded p-6">
                    <div class="inline-flex rounded bg-white p-2 shadow-lg shadow-black/10">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-14 w-auto">
                    </div>
                    <p class="mt-5 max-w-sm text-sm leading-7 text-slate-300">{{ __('ftherm.footer.summary') }}</p>
                    <h2 class="mt-6 text-xs font-black uppercase text-cyan-200">{{ __('ftherm.footer.languages') }}</h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($supportedLocales as $locale => $label)
                            <a href="{{ change_locale_url($locale) }}" class="rounded border px-3 py-2 text-sm font-black transition {{ $currentLocale === $locale ? 'border-white bg-white text-slate-950' : 'border-white/15 text-slate-300 hover:border-white hover:text-white' }}">
                                <span class="mr-1">{{ $localeFlags[$locale] }}</span>{{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="footer-panel rounded p-6">
                    <h2 class="text-xs font-black uppercase text-cyan-200">{{ __('ftherm.footer.services') }}</h2>
                    <ul class="mt-5 space-y-3 text-sm text-slate-300">
                        @foreach (array_slice(__('ftherm.services.items'), 0, 5) as $service)
                            <li>
                                <a href="{{ route('home') }}#services" class="footer-link inline-flex items-center gap-2 hover:text-white">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#DD2131]"></span>
                                    {{ $service['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-panel rounded p-6">
                    <h2 class="text-xs font-black uppercase text-cyan-200">{{ __('ftherm.footer.links') }}</h2>
                    <nav class="mt-5 grid gap-3 text-sm text-slate-300" aria-label="Footer navigation">
                        <a href="{{ route('home') }}" class="footer-link hover:text-white">{{ __('ftherm.nav.home') }}</a>
                        <a href="{{ route('home') }}#services" class="footer-link hover:text-white">{{ __('ftherm.nav.services') }}</a>
                        @if ($shopEnabled)
                            <a href="{{ route('shop.index') }}" class="footer-link hover:text-white">{{ __('ftherm.nav.products') }}</a>
                        @endif
                        <a href="{{ route('about', ['locale' => current_locale()]) }}" class="footer-link hover:text-white">{{ __('ftherm.nav.about') }}</a>
                        <a href="{{ route('home') }}#references" class="footer-link hover:text-white">{{ __('ftherm.nav.references') }}</a>
                        <a href="{{ route('home') }}#faq" class="footer-link hover:text-white">{{ __('ftherm.nav.faq') }}</a>
                        <a href="{{ route('home') }}#contact" class="footer-link hover:text-white">{{ __('ftherm.nav.contact') }}</a>
                    </nav>
                </div>

                <div class="footer-panel rounded p-6">
                    <h2 class="text-xs font-black uppercase text-cyan-200">{{ __('ftherm.footer.contact') }}</h2>
                    <div class="mt-5 space-y-3">
                        @if ($companyPhone)
                            <a href="{{ $telHref }}" class="footer-action flex items-center gap-3 rounded p-3">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded bg-[#DD2131] text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-[11px] font-black uppercase text-slate-400">{{ __('ftherm.contact.phone') }}</span>
                                    <span class="mt-0.5 block font-black text-white">{{ $companyPhone }}</span>
                                </span>
                            </a>
                        @endif
                        @if ($companyEmail)
                            <a href="mailto:{{ $companyEmail }}" class="footer-action flex items-center gap-3 rounded p-3">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded bg-[#09539A] text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-[11px] font-black uppercase text-slate-400">{{ __('ftherm.contact.email') }}</span>
                                    <span class="mt-0.5 block break-all font-black text-white">{{ $companyEmail }}</span>
                                </span>
                            </a>
                        @endif
                        @if ($companyAddress)
                            <div class="flex items-start gap-3 pt-2 text-sm leading-6 text-slate-300">
                                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.66 16.66L13.41 20.9a2 2 0 01-2.82 0l-4.25-4.24a8 8 0 1111.32 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $companyAddress }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-[1440px] flex-col gap-2 px-4 py-5 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between lg:px-10">
                <p>&copy; {{ date('Y') }} FTHERM. {{ __('ftherm.footer.rights') }}</p>
                <p class="font-semibold text-slate-300">{{ setting_value('company_name', 'FTHERM') }}</p>
            </div>
        </div>
    </footer>

    @if ($companyPhone)
        <a href="{{ $telHref }}" class="fixed bottom-4 right-4 z-30 inline-flex items-center gap-2 rounded bg-[#DD2131] px-4 py-3 text-sm font-black text-white shadow-lg shadow-red-900/20 md:hidden" aria-label="{{ __('ftherm.cta.call') }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
            </svg>
            {{ __('ftherm.cta.call') }}
        </a>
    @endif

    @stack('scripts')
</body>

</html>
