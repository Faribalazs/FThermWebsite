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
    $facebookUrl = 'https://www.facebook.com/people/FTherm/100094193259896/';
    $instagramUrl = 'https://www.instagram.com/ftherm.rs/';
    $pageTitle = trim($__env->yieldContent('title')) ?: 'FTHERM';
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: __('ftherm.seo.meta_description');
    $metaKeywords = trim($__env->yieldContent('meta_keywords')) ?: __('ftherm.seo.keywords');
    $canonicalUrl = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
    $robots = trim($__env->yieldContent('robots')) ?: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $schemaGraph = [
        [
            '@type' => ['Organization', 'LocalBusiness'],
            '@id' => url('/#organization'),
            'name' => 'FTHERM',
            'url' => url('/'),
            'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.svg')],
            'image' => $ogImage,
            'telephone' => $companyPhone,
            'email' => $companyEmail,
            'address' => $companyAddress ? ['@type' => 'PostalAddress', 'streetAddress' => $companyAddress, 'addressCountry' => 'RS'] : null,
            'sameAs' => [$facebookUrl, $instagramUrl],
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'url' => url('/'),
            'name' => 'FTHERM',
            'inLanguage' => array_keys($supportedLocales),
            'publisher' => ['@id' => url('/#organization')],
        ],
        [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $pageTitle,
            'description' => $metaDescription,
            'inLanguage' => $currentLocale,
            'isPartOf' => ['@id' => url('/#website')],
            'about' => ['@id' => url('/#organization')],
            'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
        ],
    ];
    $schemaGraph = array_map(fn ($item) => array_filter($item, fn ($value) => $value !== null && $value !== ''), $schemaGraph);
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="author" content="FTHERM">
    <meta name="theme-color" content="#071527">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="FTHERM">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @foreach ($supportedLocales as $locale => $label)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ change_locale_url($locale) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ change_locale_url('sr') }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ $pageTitle }}</title>
    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        .contact-success-popup {
            width: min(92vw, 31rem) !important;
            border: 1px solid rgba(9, 83, 154, 0.16) !important;
            border-radius: 8px !important;
            box-shadow: 0 28px 80px rgba(7, 21, 39, 0.24) !important;
        }

        .contact-success-popup .swal2-title {
            color: #071527 !important;
            font-weight: 900 !important;
            letter-spacing: 0 !important;
        }

        .contact-success-popup .swal2-html-container {
            color: #475569 !important;
            font-weight: 600 !important;
            line-height: 1.65 !important;
        }

        .contact-success-popup .swal2-success-ring {
            border-color: rgba(9, 83, 154, 0.2) !important;
        }

        .contact-success-popup .swal2-success-line-tip,
        .contact-success-popup .swal2-success-line-long {
            background-color: #09539a !important;
        }

        .contact-success-confirm {
            border-radius: 999px !important;
            background: linear-gradient(135deg, #09539a, #0c93ea) !important;
            padding: 0.85rem 1.65rem !important;
            font-weight: 900 !important;
            box-shadow: 0 14px 30px rgba(9, 83, 154, 0.25) !important;
        }

        .site-topbar {
            --site-topbar-bg: linear-gradient(135deg, rgba(7, 21, 39, 0.98), rgba(9, 83, 154, 0.96)), #071527;
            position: relative;
            z-index: 45;
            isolation: isolate;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.09);
            background: var(--site-topbar-bg);
            box-shadow: 0 10px 30px rgba(7, 21, 39, 0.18);
        }

        .site-topbar::before {
            display: none;
        }

        .site-topbar > * {
            position: relative;
            z-index: 1;
        }

        .site-topbar-contact {
            display: inline-flex;
            flex: 0 1 auto;
            min-width: 0;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.13);
            background: rgba(255, 255, 255, 0.075);
            padding: 0.42rem 0.82rem 0.42rem 0.5rem;
            color: #dbeafe;
            font-weight: 800;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.12),
                0 8px 20px rgba(2, 6, 23, 0.12);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease, color 0.18s ease;
        }

        .site-topbar-contact:hover {
            transform: translateY(-1px);
            border-color: rgba(103, 232, 249, 0.34);
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .site-topbar-contact__icon {
            display: inline-grid;
            width: 1.55rem;
            height: 1.55rem;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 999px;
            color: #ffffff;
            box-shadow: 0 9px 18px rgba(2, 6, 23, 0.18);
        }

        .site-topbar-contact--phone .site-topbar-contact__icon {
            background: linear-gradient(135deg, #dd2131, #a91624);
        }

        .site-topbar-contact--email .site-topbar-contact__icon {
            background: linear-gradient(135deg, #0c93ea, #09539a);
        }

        .site-topbar-contact__text {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .site-social-link {
            display: inline-grid;
            width: 2.35rem;
            height: 2.35rem;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.075);
            color: #ffffff;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.12),
                0 8px 20px rgba(2, 6, 23, 0.12);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        }

        .site-social-link:hover {
            transform: translateY(-1px);
            border-color: rgba(103, 232, 249, 0.34);
            background: rgba(255, 255, 255, 0.12);
        }

        .site-social-link svg {
            width: 1rem;
            height: 1rem;
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
            --site-footer-bg: linear-gradient(135deg, rgba(7, 21, 39, 0.98), rgba(9, 83, 154, 0.96)), #071527;
            position: relative;
            isolation: isolate;
            overflow: hidden;
            margin-top: 0;
            border-top: 0;
            background: var(--site-footer-bg);
            color: #ffffff;
            padding: clamp(2.4rem, 4.8vw, 3.4rem) 0 clamp(0.9rem, 2vw, 1.5rem);
            box-shadow: 0 -28px 70px rgba(7, 21, 39, 0.12);
            clip-path: polygon(
                0 26%,
                10% 21%,
                22% 16%,
                34% 11%,
                46% 8%,
                50% 7%,
                54% 8%,
                66% 11%,
                78% 16%,
                90% 21%,
                100% 26%,
                100% 100%,
                0 100%
            );
        }

        .site-footer::before {
            display: none;
        }

        .site-footer::after {
            display: none;
        }

        .footer-shell {
            width: min(1440px, calc(100% - 2rem));
        }

        .site-footer > * {
            position: relative;
            z-index: 2;
        }

        .footer-action {
            min-width: 0;
            max-width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            background: transparent;
            color: #ffffff;
            box-shadow: none;
            transition: border-color 0.18s ease, background 0.18s ease, transform 0.18s ease;
        }

        .footer-action:hover {
            transform: translateY(-1px);
            border-color: rgba(103, 232, 249, 0.36);
            background: rgba(255, 255, 255, 0.08);
        }

        .footer-action__icon {
            display: inline-grid;
            width: 1.9rem;
            height: 1.9rem;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 999px;
            color: #ffffff;
        }

        .footer-action__icon svg {
            display: block;
        }

        .footer-action--phone .footer-action__icon {
            background: linear-gradient(135deg, #dd2131, #a91624);
        }

        .footer-action--email .footer-action__icon {
            background: linear-gradient(135deg, #0c93ea, #09539a);
        }

        .footer-action__text {
            min-width: 0;
            max-width: min(18rem, 68vw);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .footer-social-link {
            display: inline-grid;
            width: 2.45rem;
            height: 2.45rem;
            flex: 0 0 auto;
            place-items: center;
            padding: 0;
        }

        .footer-social-link svg {
            display: block;
            width: 1rem;
            height: 1rem;
        }

        .footer-logo-mark {
            display: inline-flex;
            align-items: center;
            width: fit-content;
        }

        .footer-logo-mark img {
            filter: drop-shadow(0 10px 18px rgba(2, 6, 23, 0.18));
        }

        @media (max-width: 767px) {
            .site-header {
                margin-bottom: calc(-5rem - 1.7rem);
            }

            .site-nav-shell {
                border-radius: 1.45rem;
            }

            .site-topbar-contact {
                flex: 1 1 0;
                padding-right: 0.66rem;
                font-size: 0.72rem;
            }

            .site-footer {
                clip-path: none;
                padding-top: 1.35rem;
            }

            .footer-action:not(.footer-social-link) {
                width: 100%;
            }

            .footer-logo-mark {
                margin-inline: auto;
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
    @if ($companyPhone || $companyEmail || $facebookUrl || $instagramUrl)
        <div class="site-topbar text-white">
            <div class="mx-auto flex max-w-[1440px] items-center justify-center px-4 py-2 text-xs lg:px-10">
                <div class="flex w-full flex-wrap items-center justify-center gap-2 sm:w-auto sm:gap-3">
                    @if ($companyPhone)
                        <a href="{{ $telHref }}" class="site-topbar-contact site-topbar-contact--phone" aria-label="{{ __('ftherm.contact.phone') }}: {{ $companyPhone }}">
                            <span class="site-topbar-contact__icon">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                                </svg>
                            </span>
                            <span class="site-topbar-contact__text">{{ $companyPhone }}</span>
                        </a>
                    @endif
                    @if ($companyEmail)
                        <a href="mailto:{{ $companyEmail }}" class="site-topbar-contact site-topbar-contact--email" aria-label="{{ __('ftherm.contact.email') }}: {{ $companyEmail }}">
                            <span class="site-topbar-contact__icon">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="site-topbar-contact__text">{{ $companyEmail }}</span>
                        </a>
                    @endif
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="site-social-link" aria-label="FTHERM Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M14.2 8.2V6.7c0-.7.5-.9.9-.9h2.3V2.1L14.2 2c-3.6 0-4.4 2.7-4.4 4.4v1.8H7V12h2.8v10h4.1V12H17l.5-3.8h-3.3z" />
                        </svg>
                    </a>
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="site-social-link" aria-label="FTHERM Instagram">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="3" rx="5" stroke-width="2" />
                            <circle cx="12" cy="12" r="4" stroke-width="2" />
                            <circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

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
                <a href="{{ route('references.index', ['locale' => current_locale()]) }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.references') }}</a>
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

    <div x-cloak x-show="mobileMenu"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-hidden lg:hidden" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-950/60" @click="mobileMenu = false"></div>
        <div x-show="mobileMenu"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 flex h-full w-80 max-w-[88vw] flex-col overflow-hidden rounded-l-[2rem] bg-white shadow-2xl will-change-transform">
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
                    <a href="{{ route('references.index', ['locale' => current_locale()]) }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.references') }}</a>
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

    <footer class="site-footer">
        <div class="footer-shell mx-auto flex flex-col items-center gap-4 px-4 py-2 sm:flex-row sm:justify-between sm:py-3">
            <a href="{{ route('home') }}" class="footer-logo-mark" aria-label="FTHERM">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-14 w-auto sm:h-16">
            </a>

            @if ($companyPhone || $companyEmail || $facebookUrl || $instagramUrl)
                <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                    @if ($companyPhone)
                        <a href="{{ $telHref }}" class="footer-action footer-action--phone inline-flex items-center gap-2 px-2.5 py-2 text-sm font-black" aria-label="{{ __('ftherm.contact.phone') }}: {{ $companyPhone }}">
                            <span class="footer-action__icon">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                                </svg>
                            </span>
                            <span class="footer-action__text">{{ $companyPhone }}</span>
                        </a>
                    @endif
                    @if ($companyEmail)
                        <a href="mailto:{{ $companyEmail }}" class="footer-action footer-action--email inline-flex items-center gap-2 px-2.5 py-2 text-sm font-black" aria-label="{{ __('ftherm.contact.email') }}: {{ $companyEmail }}">
                            <span class="footer-action__icon">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="footer-action__text">{{ $companyEmail }}</span>
                        </a>
                    @endif
                    <div class="flex justify-center gap-2">
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="footer-action footer-social-link" aria-label="FTHERM Facebook">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor" d="M14.2 8.2V6.7c0-.7.5-.9.9-.9h2.3V2.1L14.2 2c-3.6 0-4.4 2.7-4.4 4.4v1.8H7V12h2.8v10h4.1V12H17l.5-3.8h-3.3z" />
                            </svg>
                        </a>
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="footer-action footer-social-link" aria-label="FTHERM Instagram">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="3" rx="5" stroke-width="2" />
                                <circle cx="12" cy="12" r="4" stroke-width="2" />
                                <circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
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

    @if (session('contact_success'))
        <script>
            (() => {
                const showContactSuccess = () => {
                    const message = @json(session('contact_success'));

                    if (!window.Swal) {
                        window.alert(message);
                        return;
                    }

                    window.Swal.fire({
                        icon: 'success',
                        title: @json(__('ftherm.contact.success_title')),
                        text: message,
                        confirmButtonText: @json(__('ftherm.contact.success_button')),
                        confirmButtonColor: '#09539A',
                        backdrop: 'rgba(7, 21, 39, 0.44)',
                        customClass: {
                            popup: 'contact-success-popup',
                            confirmButton: 'contact-success-confirm',
                        },
                    });
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', showContactSuccess, { once: true });
                } else {
                    showContactSuccess();
                }
            })();
        </script>
    @endif

    @stack('scripts')
</body>

</html>
