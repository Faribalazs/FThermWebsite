@extends('layouts.public')

@section('title', __('ftherm.seo.meta_title'))
@section('meta_description', __('ftherm.seo.meta_description'))
@section('meta_keywords', __('ftherm.seo.keywords'))
@section('og_image', asset('images/ftherm/hero-ftherm-technician-ac-installation.webp'))

@php
    $companyPhone = setting_value('company_phone');
    $companyEmail = setting_value('company_email');
    $companyAddress = setting_value('company_address');
    $telHref = $companyPhone ? 'tel:' . preg_replace('/[^\d+]/', '', $companyPhone) : null;
    $trustItems = __('ftherm.trust.items');
    $fallbackFaqItems = __('ftherm.faq.items');
    $serviceTypes = __('ftherm.contact.service_types');
    $trustIcons = [
        'M9 12l2 2 4-5m5 3a8 8 0 11-16 0 8 8 0 0116 0z',
        'M8 7h8M8 11h8M8 15h5M5 3h14a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 012-2z',
        'M4 7h16M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2',
        'M13 2L4 14h7l-1 8 10-13h-7l0-7z',
    ];
    $structuredData = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'FTHERM',
        'url' => route('home'),
        'image' => asset('images/ftherm/hero-ftherm-technician-ac-installation.webp'),
        'telephone' => $companyPhone,
        'email' => $companyEmail,
        'address' => $companyAddress ? ['@type' => 'PostalAddress', 'streetAddress' => $companyAddress] : null,
        'description' => __('ftherm.seo.meta_description'),
        'areaServed' => 'Serbia',
        'priceRange' => '$$',
    ]);
@endphp

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <style>
        .ftherm-home,
        .home-loader {
            --ft-navy: #071527;
            --ft-ink: #0f172a;
            --ft-blue: #09539a;
            --ft-blue-soft: #0c93ea;
            --ft-red: #dd2131;
            --ft-red-dark: #a91624;
            --ft-cyan: #67e8f9;
            --ft-ice: #f0f9ff;
            --ft-border: #d8e5f0;
            color: var(--ft-ink);
            background: #ffffff;
        }

        .home-loader {
            position: fixed;
            inset: 0;
            z-index: 80;
            display: grid;
            place-items: center;
            background:
                linear-gradient(135deg, rgba(7, 21, 39, 0.98), rgba(9, 83, 154, 0.96)),
                #071527;
            color: #ffffff;
            pointer-events: none;
            animation: loaderFallback 0.5s ease 2.8s forwards;
        }

        .home-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.45s ease, visibility 0.45s ease;
        }

        .loader-unit {
            width: min(30rem, calc(100vw - 2rem));
            text-align: center;
        }

        .loader-logo {
            display: inline-grid;
            place-items: center;
            width: min(17rem, 72vw);
            height: min(11rem, 46vw);
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 28px 90px rgba(0, 0, 0, 0.34);
        }

        .loader-logo svg {
            width: min(13.5rem, 58vw);
            height: auto;
            overflow: visible;
        }

        .loader-logo svg path {
            fill: transparent !important;
            stroke: rgba(255, 255, 255, 0.92);
            stroke-width: 12;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 4200;
            stroke-dashoffset: 4200;
            animation: logoTrace 1.65s cubic-bezier(0.2, 0.8, 0.2, 1) forwards, logoFillWhite 0.45s ease 1.45s forwards;
        }

        .loader-logo svg path:not(:first-of-type):not(:last-of-type) {
            stroke: var(--ft-blue-soft);
            animation-name: logoTrace, logoFillBlue;
        }

        .loader-logo svg path:last-of-type {
            stroke: var(--ft-red);
            animation-name: logoTrace, logoFillRed;
        }

        .loader-title {
            font-weight: 900;
            font-size: 1.05rem;
            text-transform: uppercase;
        }

        .loader-line {
            position: relative;
            height: 3px;
            margin-top: 1rem;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.16);
        }

        .loader-line::after {
            content: "";
            position: absolute;
            inset: 0;
            transform-origin: left;
            background: linear-gradient(90deg, var(--ft-cyan), #ffffff, var(--ft-red));
            animation: loaderLine 1.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .hero-premium {
            min-height: clamp(660px, 88vh, 900px);
            background: var(--ft-navy);
            border-radius: 0;
            box-shadow: none;
            border-bottom: 0;
        }

        .hero-swiper,
        .hero-swiper .swiper-wrapper,
        .hero-swiper .swiper-slide {
            min-height: inherit;
        }

        .hero-premium::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image:
                linear-gradient(90deg, #000 0%, transparent 74%),
                linear-gradient(180deg, transparent 0%, #000 18%, #000 82%, transparent 100%);
            opacity: 0.14;
            pointer-events: none;
        }

        .hero-premium::after {
            display: none;
        }

        .hero-premium__image {
            filter: saturate(1.14) contrast(1.05) brightness(1.04);
            object-position: 60% center;
        }

        .hero-premium__overlay {
            background:
                radial-gradient(circle at 78% 34%, rgba(9, 83, 154, 0.1), transparent 34%),
                radial-gradient(circle at 18% 78%, rgba(221, 33, 49, 0.08), transparent 32%),
                linear-gradient(90deg, rgba(7, 21, 39, 0.72) 0%, rgba(7, 21, 39, 0.44) 38%, rgba(7, 21, 39, 0.08) 100%),
                linear-gradient(180deg, rgba(7, 21, 39, 0.02), rgba(7, 21, 39, 0.24));
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ft-blue);
            font-size: 0.82rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .section-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ft-red);
        }

        .section-kicker--light {
            color: #bdefff;
        }

        .section-kicker--light::before {
            background: var(--ft-red);
        }

        .hero-title {
            text-wrap: balance;
            text-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
        }

        .hero-copy,
        .balanced-copy {
            text-wrap: pretty;
        }

        .ft-btn {
            position: relative;
            overflow: hidden;
            border-radius: 6px;
            transform: translateZ(0);
            transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease, border-color 0.22s ease;
        }

        .ft-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            transform: translateX(-120%) skewX(-18deg);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.28), transparent);
            transition: transform 0.7s ease;
        }

        .ft-btn:hover {
            transform: translateY(-2px);
        }

        .ft-btn:hover::after {
            transform: translateX(120%) skewX(-18deg);
        }

        .ft-btn-red {
            background: linear-gradient(135deg, var(--ft-red), var(--ft-red-dark));
            box-shadow: 0 20px 50px rgba(221, 33, 49, 0.28);
        }

        .ft-btn-blue {
            background: linear-gradient(135deg, var(--ft-blue), var(--ft-blue-soft));
            box-shadow: 0 20px 50px rgba(9, 83, 154, 0.22);
        }

        .ft-btn-ghost {
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
        }

        .hero-arrow {
            width: 3rem;
            height: 3rem;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            backdrop-filter: blur(14px);
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .hero-arrow:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.16);
        }

        .hero-pagination .swiper-pagination-bullet {
            width: 2.25rem;
            height: 3px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.36);
            opacity: 1;
        }

        .hero-pagination .swiper-pagination-bullet-active {
            background: linear-gradient(90deg, var(--ft-blue-soft), var(--ft-red));
        }

        .trust-showcase {
            isolation: isolate;
            padding-bottom: 12rem;
            background: var(--ft-blue);
            background-image: linear-gradient(var(--ft-blue) 1%, #fff 100%);
        }

        .trust-showcase::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.07) 1px, transparent 1px),
                linear-gradient(120deg, transparent 0 42%, rgba(103, 232, 249, 0.1) 42% 42.3%, transparent 42.3% 100%);
            background-size: 76px 76px, 76px 76px, 100% 100%;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, transparent 30%, #000 46%, #000 84%, transparent 100%);
            mask-image: linear-gradient(180deg, transparent 0%, transparent 30%, #000 46%, #000 84%, transparent 100%);
            opacity: 0.26;
            pointer-events: none;
        }

        .trust-showcase::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(180deg, transparent 0%, transparent 62%, rgba(255, 255, 255, 0.2) 78%, #ffffff 92%, #ffffff 100%);
            pointer-events: none;
        }

        .trust-showcase__intro {
            border-left: 3px solid var(--ft-cyan);
            color: #d9efff;
        }

        .trust-showcase .section-kicker--light::before {
            background: var(--ft-cyan);
        }

        .trust-stat {
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(7, 21, 39, 0.18);
            box-shadow: 0 18px 46px rgba(7, 21, 39, 0.12);
            backdrop-filter: blur(18px);
        }

        .trust-card {
            position: relative;
            min-height: 17rem;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.32);
            background:
                linear-gradient(180deg, rgba(7, 21, 39, 0.36), rgba(9, 83, 154, 0.22)),
                rgba(6, 32, 58, 0.34);
            box-shadow:
                0 30px 86px rgba(7, 21, 39, 0.26),
                inset 0 1px 0 rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(22px) saturate(1.16);
        }

        .trust-card::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--ft-red), var(--ft-cyan), #ffffff);
            box-shadow: 0 0 28px rgba(103, 232, 249, 0.42);
        }

        .trust-card::after {
            content: "";
            position: absolute;
            inset: auto -20% -45% 28%;
            height: 9rem;
            transform: rotate(-8deg);
            background: linear-gradient(90deg, transparent, rgba(103, 232, 249, 0.2), rgba(255, 255, 255, 0.12), transparent);
            pointer-events: none;
        }

        .trust-card__number {
            color: rgba(255, 255, 255, 0.9);
            font-size: clamp(2.5rem, 5vw, 4.75rem);
            line-height: 0.8;
        }

        .trust-card__icon {
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(103, 232, 249, 0.28), rgba(255, 255, 255, 0.1));
            color: #e8fbff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .premium-card,
        .service-card,
        .reference-card,
        .quote-panel {
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.13);
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            box-shadow: 0 16px 40px rgba(7, 21, 39, 0.07);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .premium-card:hover,
        .service-card:hover,
        .reference-card:hover,
        .quote-panel:hover {
            transform: translateY(-4px);
            border-color: rgba(9, 83, 154, 0.28);
            box-shadow: 0 28px 70px rgba(7, 21, 39, 0.12);
        }

        .service-card {
            position: relative;
            isolation: isolate;
        }

        .service-card::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            height: 3px;
            z-index: 2;
            transform: scaleX(0);
            transform-origin: left;
            background: linear-gradient(90deg, var(--ft-blue), var(--ft-cyan), var(--ft-red));
            transition: transform 0.28s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .premium-section {
            position: relative;
            overflow: hidden;
        }

        .premium-section::before {
            content: none;
            display: none;
        }

        .trust-showcase+.premium-section {
            margin-top: 0;
        }

        .split-section-light {
            background: var(--ft-blue);
        }

        .split-section-dark {
            background:
                linear-gradient(135deg, #071527 0%, #0a2d53 58%, #08111f 100%);
        }

        .faq-section {
            isolation: isolate;
            background: var(--ft-blue);
            background-image: linear-gradient(var(--ft-blue) 1%, #ffffff 100%);
        }

        .faq-section::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.07) 1px, transparent 1px),
                linear-gradient(120deg, transparent 0 42%, rgba(103, 232, 249, 0.1) 42% 42.3%, transparent 42.3% 100%);
            background-size: 76px 76px, 76px 76px, 100% 100%;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 18%, #000 78%, transparent 100%);
            mask-image: linear-gradient(180deg, transparent 0%, #000 18%, #000 78%, transparent 100%);
            opacity: 0.2;
            pointer-events: none;
        }

        .faq-shell {
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.32);
            background:
                linear-gradient(180deg, rgba(7, 21, 39, 0.28), rgba(9, 83, 154, 0.2)),
                rgba(6, 32, 58, 0.28);
            box-shadow:
                0 30px 86px rgba(7, 21, 39, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(22px) saturate(1.12);
        }

        .faq-row+.faq-row {
            border-top: 1px solid rgba(255, 255, 255, 0.16);
        }

        .faq-trigger {
            transition: background 0.2s ease, color 0.2s ease;
        }

        .faq-trigger:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .faq-answer {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition:
                grid-template-rows 0.34s cubic-bezier(0.2, 0.8, 0.2, 1),
                opacity 0.24s ease;
        }

        .faq-answer.is-open {
            grid-template-rows: 1fr;
            opacity: 1;
        }

        .faq-answer__inner {
            overflow: hidden;
        }

        .media-frame {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 34px 80px rgba(7, 21, 39, 0.18);
        }

        .media-frame::after {
            content: "";
            position: absolute;
            inset: 0;
            border: 1px solid rgba(255, 255, 255, 0.36);
            pointer-events: none;
        }

        .quote-form input,
        .quote-form select,
        .quote-form textarea {
            border-radius: 6px;
            border-color: #cbd5e1;
            background: #f8fbff;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .quote-form input:focus,
        .quote-form select:focus,
        .quote-form textarea:focus {
            border-color: var(--ft-blue);
            box-shadow: 0 0 0 4px rgba(9, 83, 154, 0.12);
            transform: translateY(-1px);
        }

        .contact-section {
            background:
                radial-gradient(circle at 12% 18%, rgba(103, 232, 249, 0.18), transparent 28%),
                radial-gradient(circle at 90% 72%, rgba(221, 33, 49, 0.08), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, #f3f9ff 52%, #ffffff 100%);
        }

        .contact-method-card {
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.13);
            background: rgba(255, 255, 255, 0.86);
            box-shadow: 0 20px 55px rgba(7, 21, 39, 0.08);
            backdrop-filter: blur(18px);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .contact-method-card:hover {
            transform: translateY(-3px);
            border-color: rgba(9, 83, 154, 0.24);
            box-shadow: 0 30px 80px rgba(7, 21, 39, 0.12);
        }

        .contact-form-shell {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.13);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 251, 255, 0.95)),
                #ffffff;
            box-shadow: 0 30px 90px rgba(7, 21, 39, 0.11);
        }

        .contact-form-shell::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--ft-blue), var(--ft-blue-soft), var(--ft-red));
        }

        .custom-service-menu {
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.14);
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 24px 60px rgba(7, 21, 39, 0.14);
            backdrop-filter: blur(18px);
        }

        .custom-service-option {
            transition: background 0.16s ease, color 0.16s ease, transform 0.16s ease;
        }

        .custom-service-option:hover {
            transform: translateX(2px);
        }

        .motion-reveal {
            opacity: 0;
            transform: translateY(26px);
            transition:
                opacity 0.72s cubic-bezier(0.2, 0.8, 0.2, 1) var(--delay, 0ms),
                transform 0.72s cubic-bezier(0.2, 0.8, 0.2, 1) var(--delay, 0ms);
        }

        .motion-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes loaderLine {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        @keyframes logoTrace {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes logoFillWhite {
            to {
                fill: rgba(255, 255, 255, 0.96);
            }
        }

        @keyframes logoFillBlue {
            to {
                fill: var(--ft-blue);
            }
        }

        @keyframes logoFillRed {
            to {
                fill: var(--ft-red);
            }
        }

        @keyframes loaderFallback {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        @keyframes heroImageDrift {
            from {
                transform: scale(1.02) translate3d(0, 0, 0);
            }

            to {
                transform: scale(1.08) translate3d(1.5%, -1%, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .home-loader {
                display: none;
            }

            .motion-reveal,
            .hero-premium__image,
            .ft-btn,
            .premium-card,
            .service-card,
            .reference-card,
            .quote-panel {
                opacity: 1 !important;
                transform: none !important;
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
    <noscript>
        <style>
            .home-loader {
                display: none;
            }

            .motion-reveal {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>
@endpush

@section('content')
    <div id="ftherm-page-loader" class="home-loader" aria-hidden="true">
        <div class="loader-unit">
            <div class="loader-logo">
                {!! file_get_contents(public_path('images/logo.svg')) !!}
            </div>
            <div class="loader-title">FTHERM</div>
            <div class="loader-line"></div>
        </div>
    </div>

    <div class="ftherm-home">
        <section id="home" class="hero-premium relative isolate overflow-hidden text-white">
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    @forelse ($slides as $slide)
                        @php
                            $slideImage = str_starts_with($slide->image, 'images/')
                                ? asset($slide->image)
                                : Storage::url($slide->image);
                            $slideTitle = translate($slide->title) ?: __('ftherm.hero.headline');
                            $slideDescription = translate($slide->description) ?: __('ftherm.hero.subheadline');
                            $slideButton = translate($slide->button_text) ?: __('ftherm.cta.quote');
                        @endphp
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0">
                                <img src="{{ $slideImage }}" alt="{{ $slideTitle }}"
                                    class="hero-premium__image h-full w-full object-cover opacity-100" width="1800"
                                    height="1013" fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                                    loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                                <div class="hero-premium__overlay absolute inset-0"></div>
                            </div>
                            <div
                                class="relative z-10 mx-auto flex min-h-[inherit] max-w-[1440px] items-center px-4 py-20 md:py-28 lg:px-10">
                                <div class="motion-reveal max-w-3xl" data-reveal>
                                    <p class="section-kicker section-kicker--light mb-5">{{ __('ftherm.hero.eyebrow') }}</p>
                                    <h1 class="hero-title text-4xl font-black leading-tight sm:text-5xl lg:text-7xl">
                                        {{ $slideTitle }}</h1>
                                    <p class="hero-copy mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                                        {{ $slideDescription }}</p>
                                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                        @if ($slide->button_link)
                                            <a href="{{ $slide->button_link }}"
                                                class="ft-btn ft-btn-red inline-flex items-center justify-center px-6 py-4 font-black text-white">{{ $slideButton }}</a>
                                        @endif
                                        <a href="#services"
                                            class="ft-btn ft-btn-ghost inline-flex items-center justify-center px-6 py-4 font-black text-white">{{ __('ftherm.cta.services') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0">
                                <img src="{{ asset('images/ftherm/slider/ac-installation-hero.webp') }}"
                                    alt="{{ __('ftherm.hero.image_alt') }}"
                                    class="hero-premium__image h-full w-full object-cover opacity-100" width="1800"
                                    height="1013" fetchpriority="high">
                                <div class="hero-premium__overlay absolute inset-0"></div>
                            </div>
                            <div
                                class="relative z-10 mx-auto flex min-h-[inherit] max-w-[1440px] items-center px-4 py-20 md:py-28 lg:px-10">
                                <div class="motion-reveal max-w-3xl" data-reveal>
                                    <p class="section-kicker section-kicker--light mb-5">{{ __('ftherm.hero.eyebrow') }}
                                    </p>
                                    <h1 class="hero-title text-4xl font-black leading-tight sm:text-5xl lg:text-7xl">
                                        {{ __('ftherm.hero.headline') }}</h1>
                                    <p class="hero-copy mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                                        {{ __('ftherm.hero.subheadline') }}</p>
                                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                        <a href="#contact"
                                            class="ft-btn ft-btn-red inline-flex items-center justify-center px-6 py-4 font-black text-white">{{ __('ftherm.cta.quote') }}</a>
                                        <a href="#services"
                                            class="ft-btn ft-btn-ghost inline-flex items-center justify-center px-6 py-4 font-black text-white">{{ __('ftherm.cta.services') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="hero-pagination swiper-pagination !bottom-8"></div>
                <div class="absolute bottom-8 right-4 z-20 hidden gap-3 lg:flex lg:right-10">
                    <button type="button" class="hero-arrow hero-prev inline-flex items-center justify-center"
                        aria-label="Previous slide">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" class="hero-arrow hero-next inline-flex items-center justify-center"
                        aria-label="Next slide">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <section class="trust-showcase premium-section py-20 md:py-28">
            <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-end">
                    <div class="motion-reveal max-w-3xl" data-reveal>
                        <p class="section-kicker section-kicker--light">{{ __('ftherm.trust.eyebrow') }}</p>
                        <h2 class="mt-4 text-3xl font-black leading-tight text-white sm:text-5xl">
                            {{ __('ftherm.trust.title') }}</h2>
                        <p class="trust-showcase__intro mt-6 max-w-2xl pl-5 text-base leading-8 sm:text-lg">
                            {{ __('ftherm.trust.intro') }}</p>
                    </div>

                    <div class="motion-reveal grid gap-3 sm:grid-cols-3" data-reveal style="--delay: 120ms">
                        @foreach (__('ftherm.trust.metrics') as $metric)
                            <div class="trust-stat px-4 py-4">
                                <p class="text-2xl font-black text-white">{{ $metric['value'] }}</p>
                                <p class="mt-1 text-xs font-black uppercase text-sky-100">{{ $metric['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($trustItems as $item)
                        <article class="trust-card motion-reveal p-5 sm:p-6" data-reveal
                            style="--delay: {{ $loop->index * 80 }}ms">
                            <div class="relative z-10 flex items-start justify-between gap-4">
                                <div class="trust-card__icon flex h-12 w-12 flex-shrink-0 items-center justify-center">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="{{ $trustIcons[$loop->index] ?? $trustIcons[0] }}" />
                                    </svg>
                                </div>
                                <span class="trust-card__number font-black">0{{ $loop->iteration }}</span>
                            </div>
                            <div class="relative z-10 mt-7">
                                <h3 class="text-xl font-black text-white">{{ $item['title'] }}</h3>
                                <p class="mt-4 text-sm leading-7 text-slate-200">{{ $item['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="services" class="premium-section bg-white pb-16 md:pb-24">
            <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="motion-reveal max-w-3xl" data-reveal>
                    <p class="section-kicker">{{ __('ftherm.services.eyebrow') }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.services.title') }}</h2>
                    <p class="balanced-copy mt-5 text-lg leading-8 text-slate-600">{{ __('ftherm.services.intro') }}</p>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse ($services as $index => $service)
                        @php
                            $serviceTitle = translate($service->title);
                            $serviceDescription = translate($service->description);
                            $serviceImage = $service->image
                                ? (str_starts_with($service->image, 'images/')
                                    ? asset($service->image)
                                    : Storage::url($service->image))
                                : asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
                            $serviceAlt = translate($service->image_alt) ?: $serviceTitle;
                            $serviceUrl = $service->slug
                                ? route('services.show', ['service' => $service->slug])
                                : '#contact';
                        @endphp
                        <article class="service-card motion-reveal group overflow-hidden" data-reveal
                            style="--delay: {{ ($index % 4) * 75 }}ms">
                            <img src="{{ $serviceImage }}" alt="{{ $serviceAlt }}"
                                class="h-40 w-full object-cover transition group-hover:scale-105" width="640"
                                height="420" loading="{{ $index < 2 ? 'eager' : 'lazy' }}">
                            <div class="p-5">
                                <h3 class="text-lg font-black text-slate-950">{{ $serviceTitle }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $serviceDescription }}</p>
                                <a href="{{ $serviceUrl }}"
                                    class="mt-5 inline-flex items-center gap-2 text-sm font-black text-sky-700 hover:text-[#DD2131]">
                                    {{ __('ftherm.services.card_cta') }}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @empty
                        @foreach (__('ftherm.services.items') as $index => $service)
                            <article class="service-card motion-reveal overflow-hidden p-5" data-reveal
                                style="--delay: {{ ($index % 4) * 75 }}ms">
                                <h3 class="text-lg font-black text-slate-950">{{ $service['title'] }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service['description'] }}</p>
                                <a href="#contact"
                                    class="mt-5 inline-flex items-center gap-2 text-sm font-black text-sky-700 hover:text-[#DD2131]">
                                    {{ __('ftherm.services.card_cta') }}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <section class="split-section-light py-24 md:py-32">
            <div class="mx-auto grid max-w-[1440px] gap-10 px-4 lg:grid-cols-2 lg:items-center lg:px-10">
                <div class="media-frame motion-reveal" data-reveal>
                    <img src="{{ asset('images/ftherm/service-ac-cleaning.webp') }}"
                        alt="{{ __('ftherm.services.items.2.alt') }}"
                        class="h-full min-h-[320px] w-full rounded object-cover" width="900" height="506"
                        loading="lazy">
                </div>
                <div class="motion-reveal flex flex-col justify-center" data-reveal style="--delay: 120ms">
                    <h2 class="text-3xl font-black text-white sm:text-5xl">{{ __('ftherm.seasonal.title') }}</h2>
                    <p class="balanced-copy mt-5 text-lg leading-8 text-sky-100">{{ __('ftherm.seasonal.text') }}</p>
                    <ul class="mt-7 grid gap-3">
                        @foreach (__('ftherm.seasonal.bullets') as $bullet)
                            <li class="flex items-start gap-3 text-white">
                                <span
                                    class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-[#DD2131] text-white shadow-lg shadow-red-950/20">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span class="font-semibold">{{ $bullet }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="#contact"
                        class="ft-btn ft-btn-red mt-8 inline-flex w-fit px-6 py-4 font-black text-white">{{ __('ftherm.seasonal.cta') }}</a>
                </div>
            </div>
        </section>

        <section id="references" class="premium-section bg-white py-16 md:py-24">
            <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="motion-reveal flex flex-col gap-5 md:flex-row md:items-end md:justify-between" data-reveal>
                    <div class="max-w-3xl">
                        <h2 class="text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.gallery.title') }}</h2>
                        <p class="balanced-copy mt-5 text-lg leading-8 text-slate-600">{{ __('ftherm.gallery.text') }}</p>
                    </div>
                    <a href="{{ route('gallery.index', current_locale()) }}"
                        class="ft-btn inline-flex w-fit border border-slate-300 px-5 py-3 font-black text-slate-800 transition hover:bg-slate-950 hover:text-white">{{ __('ftherm.gallery.cta') }}</a>
                </div>

                @if ($galleryAlbums->count())
                    <div class="mt-10 grid gap-5 md:grid-cols-3">
                        @foreach ($galleryAlbums as $album)
                            <a href="{{ route('gallery.show', ['locale' => current_locale(), 'slug' => $album->slug]) }}"
                                class="reference-card motion-reveal group overflow-hidden" data-reveal
                                style="--delay: {{ $loop->index * 80 }}ms">
                                @if ($album->images->first())
                                    <img src="{{ Storage::url($album->images->first()->path) }}"
                                        alt="{{ translate($album->title) }}"
                                        class="h-56 w-full object-cover transition group-hover:scale-105" width="640"
                                        height="420" loading="lazy">
                                @else
                                    <img src="{{ asset('images/slider/slide2.jpg') }}"
                                        alt="{{ translate($album->title) }}"
                                        class="h-56 w-full object-cover transition group-hover:scale-105" width="640"
                                        height="420" loading="lazy">
                                @endif
                                <div class="p-5">
                                    <h3 class="font-black text-slate-950 group-hover:text-sky-700">
                                        {{ translate($album->title) }}</h3>
                                    @if (translate($album->description))
                                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">
                                            {{ translate($album->description) }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-10 grid gap-5 md:grid-cols-3">
                        @foreach (['images/ftherm/gallery-ac-installation.webp', 'images/ftherm/gallery-heat-pump.webp', 'images/ftherm/gallery-plumbing.webp'] as $image)
                            <div class="reference-card motion-reveal overflow-hidden" data-reveal
                                style="--delay: {{ $loop->index * 80 }}ms">
                                <img src="{{ asset($image) }}" alt="{{ __('ftherm.gallery.text') }}"
                                    class="h-56 w-full object-cover" width="640" height="420" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-4 text-sm font-semibold text-slate-500">{{ __('ftherm.gallery.placeholder') }}</p>
                @endif
            </div>
        </section>

        @if ($shopEnabled && $featured_products->count())
            <section class="premium-section bg-slate-50 py-16 md:py-24">
                <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                    <div class="motion-reveal flex flex-col gap-5 md:flex-row md:items-end md:justify-between" data-reveal>
                        <div>
                            <p class="text-sm font-black uppercase text-sky-700">{{ __('frontend.products_badge') }}</p>
                            <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">
                                {{ __('frontend.products_title') }}</h2>
                            <p class="mt-4 text-lg text-slate-600">{{ __('frontend.products_subtitle') }}</p>
                        </div>
                        <a href="{{ route('shop.index') }}"
                            class="ft-btn ft-btn-blue inline-flex w-fit px-5 py-3 font-black text-white">{{ __('frontend.products_view_all') }}</a>
                    </div>
                    <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($featured_products as $product)
                            <a href="{{ route('shop.show', $product) }}"
                                class="service-card motion-reveal group overflow-hidden" data-reveal
                                style="--delay: {{ ($loop->index % 3) * 80 }}ms">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                        alt="{{ translate($product->name) }}"
                                        class="h-56 w-full object-cover transition group-hover:scale-105" width="640"
                                        height="420" loading="lazy">
                                @else
                                    <div class="flex h-56 items-center justify-center bg-sky-50 text-sky-300">
                                        <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h3 class="font-black text-slate-950 group-hover:text-sky-700">
                                        {{ translate($product->name) }}</h3>
                                    @if ($product->price)
                                        <p class="mt-3 text-xl font-black text-sky-700">
                                            {{ number_format($product->price, 2) }} RSD</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @php
            $displayFaqItems = ($faqItems ?? collect())->count()
                ? $faqItems
                : collect($fallbackFaqItems);
        @endphp

        <section id="faq" class="faq-section premium-section py-16 md:py-24">
            <div class="mx-auto max-w-[960px] px-4 lg:px-10">
                <h2 class="motion-reveal text-3xl font-black text-white sm:text-5xl" data-reveal>
                    {{ __('ftherm.faq.title') }}</h2>
                <div class="faq-shell motion-reveal mt-8"
                    x-data="{ open: 0 }" data-reveal style="--delay: 100ms">
                    @foreach ($displayFaqItems as $index => $item)
                        @php
                            $question = is_array($item) ? ($item['question'] ?? '') : translate($item->question ?? '');
                            $answer = is_array($item) ? ($item['answer'] ?? '') : translate($item->answer ?? '');
                        @endphp
                        <article class="faq-row">
                            <button type="button"
                                class="faq-trigger flex w-full items-center justify-between gap-5 px-5 py-5 text-left font-black text-white"
                                @click="open = open === {{ $index }} ? null : {{ $index }}"
                                :aria-expanded="(open === {{ $index }}).toString()"
                                aria-controls="faq-panel-{{ $index }}">
                                <span>{{ $question }}</span>
                                <svg class="h-5 w-5 flex-shrink-0 text-cyan-100 transition duration-300"
                                    :class="open === {{ $index }} ? 'rotate-180' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-cloak id="faq-panel-{{ $index }}" class="faq-answer"
                                :class="open === {{ $index }} ? 'is-open' : ''"
                                :aria-hidden="(open !== {{ $index }}).toString()">
                                <div class="faq-answer__inner">
                                    <p class="px-5 pb-5 leading-7 text-sky-100">{{ $answer }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="contact-section premium-section py-16 md:py-24">
            <div class="mx-auto grid max-w-[1440px] gap-8 px-4 lg:grid-cols-[0.9fr_1.1fr] lg:items-start lg:px-10">
                <div class="motion-reveal" data-reveal>
                    <p class="section-kicker">{{ __('ftherm.nav.contact') }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.contact.title') }}</h2>
                    <p class="balanced-copy mt-5 text-lg leading-8 text-slate-600">{{ __('ftherm.contact.subtitle') }}</p>

                    <div class="mt-8 grid gap-4">
                        @if ($companyPhone)
                            <a href="{{ $telHref }}"
                                class="contact-method-card group flex items-center gap-5 p-5 sm:p-6">
                                <span
                                    class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded bg-[#DD2131] text-white shadow-lg shadow-red-900/20 sm:h-16 sm:w-16">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span
                                        class="block text-xs font-black uppercase text-slate-500">{{ __('ftherm.contact.phone') }}</span>
                                    <span
                                        class="mt-1 block break-words text-2xl font-black leading-tight text-slate-950 sm:text-3xl">{{ $companyPhone }}</span>
                                </span>
                            </a>
                        @endif

                        @if ($companyEmail)
                            <a href="mailto:{{ $companyEmail }}"
                                class="contact-method-card group flex items-center gap-5 p-5 sm:p-6">
                                <span
                                    class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded bg-[#09539A] text-white shadow-lg shadow-sky-900/20 sm:h-16 sm:w-16">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span
                                        class="block text-xs font-black uppercase text-slate-500">{{ __('ftherm.contact.email') }}</span>
                                    <span
                                        class="mt-1 block break-all text-xl font-black leading-tight text-slate-950 sm:text-2xl">{{ $companyEmail }}</span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="motion-reveal" data-reveal style="--delay: 120ms">
                    @if (session('success'))
                        <div
                            class="mb-5 rounded border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">
                            {{ session('success') }}</div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST"
                        class="quote-form contact-form-shell grid gap-5 p-5 pt-8 sm:p-7 sm:pt-9">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name"
                                    class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.name') }}
                                    *</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}"
                                    required
                                    class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
                                @error('name')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="city"
                                    class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.city') }}</label>
                                <input id="city" name="city" type="text" value="{{ old('city') }}"
                                    class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
                                @error('city')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="phone"
                                    class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.phone') }}
                                    *</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    required
                                    class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
                                @error('phone')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email"
                                    class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.email') }}</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
                                @error('email')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @php
                            $selectedServiceType = old('service_type', '');
                            $selectedServiceTypeLabel =
                                $selectedServiceType && isset($serviceTypes[$selectedServiceType])
                                    ? $serviceTypes[$selectedServiceType]
                                    : __('ftherm.contact.service_type');
                        @endphp
                        <div>
                            <label for="service_type"
                                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.service_type') }}</label>
                            <div class="relative" x-data="{ open: false, selected: @js($selectedServiceType), selectedLabel: @js($selectedServiceTypeLabel), choose(value, label) { this.selected = value;
                                    this.selectedLabel = label;
                                    this.open = false; } }" @keydown.escape.window="open = false">
                                <input id="service_type" name="service_type" type="hidden" x-model="selected">
                                <button type="button" @click="open = !open"
                                    class="flex h-14 w-full items-center justify-between gap-3 rounded border border-slate-300 bg-[#f8fbff] px-4 text-left text-base transition focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-700/10"
                                    :class="open ? 'border-sky-600 ring-4 ring-sky-700/10' : ''" aria-haspopup="listbox"
                                    :aria-expanded="open.toString()">
                                    <span class="min-w-0 truncate"
                                        :class="selected ? 'text-slate-950 font-bold' : 'text-slate-500'"
                                        x-text="selectedLabel"></span>
                                    <span
                                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded bg-white text-sky-700 shadow-sm">
                                        <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div x-cloak x-show="open" x-transition @click.outside="open = false"
                                    class="custom-service-menu absolute left-0 right-0 z-30 mt-2 max-h-72 overflow-y-auto p-2"
                                    role="listbox">
                                    <button type="button" @click="choose('', @js(__('ftherm.contact.service_type')))"
                                        class="custom-service-option flex w-full items-center justify-between rounded px-3 py-3 text-left text-sm font-bold text-slate-500 hover:bg-slate-50">
                                        {{ __('ftherm.contact.service_type') }}
                                    </button>
                                    @foreach ($serviceTypes as $value => $label)
                                        <button type="button"
                                            @click="choose(@js($value), @js($label))"
                                            class="custom-service-option flex w-full items-center justify-between gap-3 rounded px-3 py-3 text-left text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-800"
                                            :class="selected === @js($value) ? 'bg-sky-50 text-sky-800' : ''"
                                            role="option"
                                            :aria-selected="(selected === @js($value)).toString()">
                                            <span>{{ $label }}</span>
                                            <svg x-show="selected === @js($value)" x-cloak
                                                class="h-4 w-4 flex-shrink-0 text-[#DD2131]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            @error('service_type')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message"
                                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.message') }}
                                *</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full rounded border-slate-300 px-4 py-3 text-base focus:border-sky-500 focus:ring-sky-500">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="ft-btn ft-btn-blue inline-flex justify-center px-6 py-4 text-base font-black text-white">{{ __('ftherm.contact.send') }}</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('ftherm-page-loader');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const loaderStartedAt = performance.now();
            const loaderMinimumMs = 1800;

            if (window.Swiper && document.querySelector('.hero-swiper')) {
                new Swiper('.hero-swiper', {
                    loop: true,
                    speed: reduceMotion ? 0 : 950,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    autoplay: reduceMotion ? false : {
                        delay: 5400,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.hero-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.hero-next',
                        prevEl: '.hero-prev'
                    },
                    keyboard: {
                        enabled: true
                    }
                });
            }

            function hideLoader() {
                if (loader) {
                    loader.classList.add('is-hidden');
                }
            }

            function queueLoaderHide() {
                const elapsed = performance.now() - loaderStartedAt;
                const wait = Math.max(0, loaderMinimumMs - elapsed);
                setTimeout(hideLoader, wait);
            }

            if (reduceMotion) {
                hideLoader();
            } else {
                window.addEventListener('load', function() {
                    queueLoaderHide();
                }, {
                    once: true
                });
                setTimeout(queueLoaderHide, 2800);
            }

            const revealItems = document.querySelectorAll('[data-reveal]');

            if (reduceMotion || !('IntersectionObserver' in window)) {
                revealItems.forEach(function(item) {
                    item.classList.add('is-visible');
                });
                return;
            }

            const revealObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.16,
                rootMargin: '0px 0px -8% 0px'
            });

            revealItems.forEach(function(item) {
                revealObserver.observe(item);
            });
        });
    </script>
@endpush
