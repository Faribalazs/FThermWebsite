<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

@php
    $supportedLocales = ['hu' => 'HU', 'sr' => 'SR', 'en' => 'EN'];
    $localeNames = ['hu' => 'Magyar', 'sr' => 'Srpski', 'en' => 'English'];
    $localeFlags = ['hu' => '🇭🇺', 'sr' => '🇷🇸', 'en' => '🇬🇧'];
    $currentLocale = current_locale();
    $localSeoLinks = [
        [
            'route' => 'local-seo.air-conditioning',
            'label' => $currentLocale === 'hu' ? 'Klímaszerelés Szabadka' : ($currentLocale === 'en' ? 'Air conditioning Subotica' : 'Klime Subotica'),
        ],
        [
            'route' => 'local-seo.heat-pumps',
            'label' => $currentLocale === 'hu' ? 'Hőszivattyú Szabadka' : ($currentLocale === 'en' ? 'Heat pumps Subotica' : 'Toplotne pumpe Subotica'),
        ],
    ];
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
            'alternateName' => 'FTHERM Subotica',
            'url' => url('/'),
            'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.svg')],
            'image' => $ogImage,
            'telephone' => $companyPhone,
            'email' => $companyEmail,
            'contactPoint' => ($companyPhone || $companyEmail) ? [
                '@type' => 'ContactPoint',
                'telephone' => $companyPhone,
                'email' => $companyEmail,
                'contactType' => 'customer service',
                'areaServed' => 'RS',
                'availableLanguage' => ['sr', 'hu', 'en'],
            ] : null,
            'address' => $companyAddress ? ['@type' => 'PostalAddress', 'streetAddress' => $companyAddress, 'addressLocality' => 'Subotica', 'postalCode' => '24000', 'addressCountry' => 'RS'] : null,
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Subotica'],
                ['@type' => 'Place', 'name' => 'Palić'],
                ['@type' => 'AdministrativeArea', 'name' => 'Severnobački okrug'],
            ],
            'sameAs' => [$facebookUrl, $instagramUrl],
            'knowsAbout' => [
                'Montaža i ugradnja klima uređaja',
                'Servis i popravka klima uređaja',
                'Čišćenje i dezinfekcija klima uređaja',
                'Toplotne pumpe',
                'Podno i zidno grejanje',
                'Vodoinstalacije',
                'Rashladne komore i rashladna tehnika',
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'FTHERM usluge u Subotici i okolini',
                'itemListElement' => [
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Montaža klime Subotica', 'url' => url('/sr/klime-subotica')]],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Servis i čišćenje klima uređaja Subotica', 'url' => url('/sr/services/ac-cleaning-disinfection')]],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Toplotne pumpe Subotica', 'url' => url('/sr/toplotne-pumpe-subotica')]],
                ],
            ],
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
            '@type' => request()->routeIs('contact') ? 'ContactPage' : 'WebPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $pageTitle,
            'description' => $metaDescription,
            'inLanguage' => $currentLocale,
            'isPartOf' => ['@id' => url('/#website')],
            'about' => ['@id' => url('/#organization')],
            'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
            'potentialAction' => [
                '@type' => 'CommunicateAction',
                'target' => route('contact', ['locale' => $currentLocale]),
                'name' => __('ftherm.cta.quote'),
            ],
        ],
    ];
    $schemaGraph = array_map(fn ($item) => array_filter($item, fn ($value) => $value !== null && $value !== ''), $schemaGraph);
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
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
    <script type="application/ld+json">{!! json_encode([chr(64).'context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="public-site bg-white font-sans antialiased text-slate-900" x-data="publicNavigation" @keydown.escape.window="languageOpen = false">
    @if ($companyPhone || $companyEmail || $facebookUrl || $instagramUrl)
        <div class="site-topbar text-white">
            <div class="site-topbar-inner mx-auto flex max-w-[1440px] items-center justify-center text-xs">
                <div class="site-topbar-items flex w-full items-center justify-center sm:w-auto">
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
        <nav class="site-nav-shell mx-auto flex max-w-[1440px] items-center justify-between px-4 lg:px-10" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="FTHERM">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="site-logo w-auto">
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.home') }}</a>
                <div class="site-nav-services">
                    <a href="{{ route('home') }}#services" class="site-nav-link site-nav-services__trigger px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">
                        <span>{{ __('ftherm.nav.services') }}</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div class="site-nav-services__menu" aria-label="{{ __('ftherm.nav.services') }}">
                        @foreach ($localSeoLinks as $localLink)
                            <a href="{{ route($localLink['route'], ['locale' => $currentLocale]) }}" class="site-nav-services__option">
                                <span>{{ $localLink['label'] }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
                @if ($shopEnabled)
                    <a href="{{ route('shop.index') }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.products') }}</a>
                @endif
                <a href="{{ route('about', ['locale' => current_locale()]) }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.about') }}</a>
                <a href="{{ route('references.index', ['locale' => current_locale()]) }}" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.references') }}</a>
                <a href="{{ route('home') }}#faq" class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.faq') }}</a>
                <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif class="site-nav-link px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-700">{{ __('ftherm.nav.contact') }}</a>
            </div>

            <div class="flex items-center gap-2">
                <div class="site-language-switcher relative" @click.outside="languageOpen = false">
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
                <button type="button" @click="mobileMenu = true" class="site-icon-button inline-flex items-center justify-center border border-slate-200 text-slate-700 lg:hidden" aria-label="{{ __('ftherm.mobile.menu') }}" aria-controls="mobile-menu" :aria-expanded="mobileMenu.toString()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <dialog id="mobile-menu" x-ref="mobileDialog" class="site-mobile-menu" aria-label="{{ __('ftherm.mobile.menu') }}"
        @close="if (!$event.target.open) mobileMenu = false" @cancel.prevent="mobileMenu = false" @click.self="mobileMenu = false">
        <div class="site-mobile-menu__panel">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-12 w-auto">
                <button type="button" @click="mobileMenu = false" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-700" aria-label="{{ __('ftherm.mobile.close') }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto px-5 py-5">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.home') }}</a>
                    <a href="{{ route('home') }}#services" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.services') }}</a>
                    <div class="site-mobile-local-links">
                        @foreach ($localSeoLinks as $localLink)
                            <a href="{{ route($localLink['route'], ['locale' => $currentLocale]) }}" @click="mobileMenu = false" class="site-mobile-local-link">
                                <span>{{ $localLink['label'] }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                    @if ($shopEnabled)
                        <a href="{{ route('shop.index') }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.products') }}</a>
                    @endif
                    <a href="{{ route('about', ['locale' => current_locale()]) }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.about') }}</a>
                    <a href="{{ route('references.index', ['locale' => current_locale()]) }}" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.references') }}</a>
                    <a href="{{ route('home') }}#faq" @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.faq') }}</a>
                    <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif @click="mobileMenu = false" class="site-mobile-nav-link block rounded-full px-3 py-3 font-bold text-slate-800 hover:bg-sky-50">{{ __('ftherm.nav.contact') }}</a>
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
    </dialog>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-shell mx-auto flex flex-col items-center gap-4 px-4 py-2 xl:flex-row xl:justify-between sm:py-3">
            <a href="{{ route('home') }}" class="footer-logo-mark" aria-label="FTHERM">
                <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-14 w-auto sm:h-16">
            </a>

            <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm font-bold text-slate-200">
                @foreach ($localSeoLinks as $localLink)
                    <a href="{{ route($localLink['route'], ['locale' => $currentLocale]) }}" class="hover:text-white">{{ $localLink['label'] }}</a>
                @endforeach
                <a href="{{ route('contact') }}" class="hover:text-white">{{ __('ftherm.nav.contact') }}</a>
            </div>

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
        <div class="footer-shell mx-auto mt-6 px-4">
            <x-company-details :dark="true" :exclude="['company_name', 'company_address']" />
            <p class="border-t border-white/15 pt-4 text-center text-xs leading-6 text-sky-100">© {{ date('Y') }} FTHERM. {{ __('ftherm.footer.rights') }}</p>
        </div>
    </footer>

    @include('components.mobile-app-nav')

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
