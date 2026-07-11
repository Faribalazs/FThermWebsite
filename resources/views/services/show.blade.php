@extends('layouts.public')

@php
    $title = translate($service->title);
    $description = translate($service->description);
    $content = translate($service->content);
    $contentHtml = $content ?: '<p>' . e($description) . '</p>';
    $image = $service->image
        ? (str_starts_with($service->image, 'images/') ? asset($service->image) : Storage::url($service->image))
        : asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
    $imageAlt = translate($service->image_alt) ?: $title;

    $companyPhone = setting_value('company_phone');
    $companyEmail = setting_value('company_email');
    $telHref = $companyPhone ? 'tel:' . preg_replace('/[^\d+]/', '', $companyPhone) : null;
    $facebookUrl = 'https://www.facebook.com/people/FTherm/100094193259896/';
    $instagramUrl = 'https://www.instagram.com/ftherm.rs/';
    $serviceTypes = __('ftherm.contact.service_types');
    $serviceTypeBySlug = [
        'air-conditioning-installation' => 'air_conditioning_installation',
        'ac-service-repair' => 'ac_service_repair',
        'ac-cleaning-disinfection' => 'ac_cleaning',
        'heat-pumps' => 'heat_pump',
        'underfloor-wall-heating' => 'underfloor_wall_heating',
        'radiators-heating-systems' => 'radiators_heating',
        'plumbing' => 'plumbing',
        'cold-rooms-refrigeration' => 'cold_room_refrigeration',
    ];
    $defaultServiceType = $serviceTypeBySlug[$service->slug] ?? '';
    $defaultServiceType = isset($serviceTypes[$defaultServiceType]) ? $defaultServiceType : '';
@endphp

@section('title', $title . ' | FTHERM')
@section('meta_description', Str::limit(strip_tags($description), 155))
@section('og_image', $image)

@push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => url()->current() . '#service',
        'name' => $title,
        'description' => Str::limit(strip_tags($description), 300),
        'image' => $image,
        'url' => url()->current(),
        'areaServed' => ['@type' => 'Country', 'name' => 'Serbia'],
        'provider' => ['@id' => url('/#organization')],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <style>
        .service-page {
            --ft-navy: #071527;
            --ft-blue: #09539a;
            --ft-blue-soft: #0c93ea;
            --ft-red: #dd2131;
            --ft-red-dark: #a91624;
            --ft-cyan: #67e8f9;
            --ft-ink: #0f172a;
            --ft-muted: #64748b;
            color: var(--ft-ink);
            background: #ffffff;
        }

        .service-container {
            width: min(1440px, calc(100% - 2rem));
            margin-inline: auto;
        }

        .service-hero {
            position: relative;
            isolation: isolate;
            min-height: clamp(560px, 78vh, 840px);
            overflow: hidden;
            background: var(--ft-navy);
            color: #ffffff;
        }

        .service-hero::before {
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

        .service-hero__image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(1.14) contrast(1.05) brightness(1.04);
        }

        .service-hero__overlay {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 78% 34%, rgba(9, 83, 154, 0.1), transparent 34%),
                radial-gradient(circle at 18% 78%, rgba(221, 33, 49, 0.08), transparent 32%),
                linear-gradient(90deg, rgba(7, 21, 39, 0.72) 0%, rgba(7, 21, 39, 0.44) 38%, rgba(7, 21, 39, 0.08) 100%),
                linear-gradient(180deg, rgba(7, 21, 39, 0.02), rgba(7, 21, 39, 0.24));
        }

        .service-hero__inner {
            position: relative;
            z-index: 2;
            display: flex;
            min-height: inherit;
            align-items: center;
            padding-block: clamp(9rem, 16vw, 12rem) clamp(4rem, 8vw, 7rem);
        }

        .service-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: #bdefff;
            font-size: 0.82rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .service-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ft-red);
        }

        .service-section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ft-blue);
            font-size: 0.82rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .service-section-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ft-red);
        }

        .service-title {
            max-width: 920px;
            text-wrap: balance;
            text-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
        }

        .service-hero-copy {
            max-width: 680px;
            color: #dbeafe;
            text-wrap: pretty;
        }

        .service-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 6px;
            padding: 1rem 1.5rem;
            font-weight: 900;
            transition: transform 0.22s ease, background 0.22s ease, border-color 0.22s ease;
        }

        .service-btn:hover {
            transform: translateY(-2px);
        }

        .service-btn--red {
            background: linear-gradient(135deg, var(--ft-red), var(--ft-red-dark));
            color: #ffffff;
            box-shadow: 0 20px 50px rgba(221, 33, 49, 0.28);
        }

        .service-btn--ghost {
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            backdrop-filter: blur(14px);
        }

        .service-description-section,
        .service-related-section,
        .contact-section {
            position: relative;
            background: #ffffff;
        }

        .service-description-card {
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.13);
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            box-shadow: 0 18px 60px rgba(7, 21, 39, 0.08);
        }

        .service-lead {
            max-width: 920px;
            color: #475569;
            font-size: clamp(1.05rem, 2vw, 1.25rem);
            line-height: 1.85;
            text-wrap: pretty;
        }

        .service-body {
            color: #475569;
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .service-body h2,
        .service-body h3 {
            margin-top: 2.35rem;
            margin-bottom: 1rem;
            color: #0f172a;
            font-weight: 950;
            line-height: 1.18;
            text-wrap: balance;
        }

        .service-body h2:first-child,
        .service-body h3:first-child {
            margin-top: 0;
        }

        .service-body h2 {
            font-size: clamp(1.85rem, 3vw, 2.6rem);
        }

        .service-body h3 {
            font-size: 1.35rem;
        }

        .service-body p,
        .service-body ul,
        .service-body ol {
            margin-top: 1rem;
        }

        .service-body ul,
        .service-body ol {
            padding-left: 1.2rem;
        }

        .service-body li {
            margin-top: 0.55rem;
        }

        .service-body strong {
            color: #0f172a;
        }

        .service-related-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .service-related-card,
        .contact-method-card {
            border-radius: 8px;
            border: 1px solid rgba(9, 83, 154, 0.13);
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            box-shadow: 0 16px 40px rgba(7, 21, 39, 0.07);
            transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
        }

        .service-related-card:hover,
        .contact-method-card:hover {
            transform: translateY(-4px);
            border-color: rgba(9, 83, 154, 0.28);
            box-shadow: 0 28px 70px rgba(7, 21, 39, 0.12);
        }

        .service-related-card {
            position: relative;
            display: flex;
            min-height: 100%;
            overflow: hidden;
            flex-direction: column;
        }

        .service-related-card::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            z-index: 2;
            height: 3px;
            transform: scaleX(0);
            transform-origin: left;
            background: linear-gradient(90deg, var(--ft-blue), var(--ft-cyan), var(--ft-red));
            transition: transform 0.28s ease;
        }

        .service-related-card:hover::before {
            transform: scaleX(1);
        }

        .service-related-card__media {
            position: relative;
            aspect-ratio: 1.45;
            overflow: hidden;
            background: #eef6ff;
        }

        .service-related-card__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.52s ease;
        }

        .service-related-card:hover .service-related-card__media img {
            transform: scale(1.055);
        }

        .service-related-card__body {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            padding: 1.15rem;
        }

        .service-related-card__number {
            color: var(--ft-blue);
            font-size: 0.72rem;
            font-weight: 950;
            text-transform: uppercase;
        }

        .service-related-card__title {
            margin-top: 0.55rem;
            color: #020617;
            font-size: 1.08rem;
            font-weight: 950;
            line-height: 1.22;
            transition: color 0.2s ease;
        }

        .service-related-card:hover .service-related-card__title {
            color: var(--ft-blue);
        }

        .service-related-card__text {
            display: -webkit-box;
            margin-top: 0.7rem;
            overflow: hidden;
            color: var(--ft-muted);
            font-size: 0.92rem;
            line-height: 1.65;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .service-related-card__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: auto;
            padding-top: 1rem;
            color: var(--ft-blue);
            font-size: 0.9rem;
            font-weight: 950;
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

        .contact-method-card {
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(18px);
        }

        .contact-social-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .contact-social-card {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
        }

        .contact-social-card__icon {
            display: grid;
            width: 3.25rem;
            height: 3.25rem;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 8px;
            color: #ffffff;
            box-shadow: 0 16px 34px rgba(7, 21, 39, 0.15);
        }

        .contact-social-card__icon svg {
            width: 1.35rem;
            height: 1.35rem;
        }

        .contact-social-card--facebook .contact-social-card__icon {
            background: linear-gradient(135deg, #1877f2, #09539a);
        }

        .contact-social-card--instagram .contact-social-card__icon {
            background: linear-gradient(135deg, #833ab4, #e1306c 52%, #f77737);
        }

        .contact-social-card__label {
            display: block;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .contact-social-card__title {
            display: block;
            margin-top: 0.2rem;
            color: #020617;
            font-size: 1.02rem;
            font-weight: 900;
            line-height: 1.15;
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

        @media (max-width: 1024px) {
            .service-related-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .service-container {
                width: min(100% - 1rem, 1440px);
            }

            .service-hero {
                min-height: 600px;
            }

            .service-related-grid,
            .contact-social-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-page">
        <section class="service-hero">
            <img src="{{ $image }}" alt="{{ $imageAlt }}" class="service-hero__image" width="1800" height="1013"
                fetchpriority="high">
            <div class="service-hero__overlay"></div>
            <div class="service-container service-hero__inner">
                <div>
                    <p class="service-kicker">{{ __('ftherm.services.eyebrow') }}</p>
                    <h1 class="service-title mt-5 text-4xl font-black leading-tight sm:text-5xl lg:text-7xl">
                        {{ $title }}</h1>
                    <p class="service-hero-copy mt-6 text-base leading-8 sm:text-lg">{{ $description }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#contact" class="service-btn service-btn--red">{{ __('ftherm.cta.quote') }}</a>
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#services"
                            class="service-btn service-btn--ghost">{{ __('ftherm.services.all_services') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="service-description-section py-16 md:py-24">
            <div class="service-container">
                <div class="service-description-card p-5 sm:p-8 lg:p-10">
                    <p class="service-section-kicker">{{ __('ftherm.services.next_step_eyebrow') }}</p>
                    <p class="service-lead mt-5">{{ $description }}</p>
                    <article class="service-body mt-8">
                        {!! $contentHtml !!}
                    </article>
                </div>
            </div>
        </section>

        @if ($relatedServices->isNotEmpty())
            <section class="service-related-section pb-16 md:pb-24">
                <div class="service-container">
                    <div class="mb-8 max-w-3xl">
                        <p class="service-section-kicker">{{ __('ftherm.services.all_services') }}</p>
                        <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">
                            {{ __('ftherm.services.related') }}</h2>
                    </div>
                    <div class="service-related-grid">
                        @foreach ($relatedServices as $related)
                            @php
                                $relatedTitle = translate($related->title);
                                $relatedDescription = translate($related->description);
                                $relatedImage = $related->image
                                    ? (str_starts_with($related->image, 'images/')
                                        ? asset($related->image)
                                        : Storage::url($related->image))
                                    : asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
                                $relatedAlt = translate($related->image_alt) ?: $relatedTitle;
                            @endphp
                            <a href="{{ route('services.show', ['locale' => current_locale(), 'service' => $related->slug]) }}"
                                class="service-related-card">
                                <div class="service-related-card__media">
                                    <img src="{{ $relatedImage }}" alt="{{ $relatedAlt }}" loading="lazy">
                                </div>
                                <div class="service-related-card__body">
                                    <span class="service-related-card__number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="service-related-card__title">{{ $relatedTitle }}</h3>
                                    <p class="service-related-card__text">{{ $relatedDescription }}</p>
                                    <span class="service-related-card__cta">
                                        {{ __('ftherm.services.card_cta') }}
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section id="contact" class="contact-section py-16 md:py-24">
            <div class="service-container grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <p class="service-section-kicker">{{ __('ftherm.nav.contact') }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.contact.title') }}</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">{{ __('ftherm.contact.subtitle') }}</p>

                    <div class="mt-8 grid gap-4">
                        @if ($companyPhone)
                            <a href="{{ $telHref }}" class="contact-method-card group flex items-center gap-5 p-5 sm:p-6">
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

                        <div class="contact-social-grid">
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                                class="contact-method-card contact-social-card contact-social-card--facebook"
                                aria-label="FTHERM Facebook">
                                <span class="contact-social-card__icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill="currentColor"
                                            d="M14.2 8.2V6.7c0-.7.5-.9.9-.9h2.3V2.1L14.2 2c-3.6 0-4.4 2.7-4.4 4.4v1.8H7V12h2.8v10h4.1V12H17l.5-3.8h-3.3z" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="contact-social-card__label">Facebook</span>
                                    <span class="contact-social-card__title">FTherm</span>
                                </span>
                            </a>

                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                                class="contact-method-card contact-social-card contact-social-card--instagram"
                                aria-label="FTHERM Instagram">
                                <span class="contact-social-card__icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect width="18" height="18" x="3" y="3" rx="5" stroke-width="2" />
                                        <circle cx="12" cy="12" r="4" stroke-width="2" />
                                        <circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="contact-social-card__label">Instagram</span>
                                    <span class="contact-social-card__title">@ftherm.rs</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <form action="{{ route('contact.store') }}" method="POST"
                        class="quote-form contact-form-shell grid gap-5 p-5 pt-8 sm:p-7 sm:pt-9">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name"
                                    class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.name') }}
                                    *</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required
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
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required
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
                            $selectedServiceType = old('service_type', $defaultServiceType);
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
                                <input id="service_type" name="service_type" type="hidden"
                                    value="{{ $selectedServiceType }}" x-model="selected">
                                <button type="button" @click="open = !open"
                                    class="flex h-14 w-full items-center justify-between gap-3 rounded border border-slate-300 bg-[#f8fbff] px-4 text-left text-base transition focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-700/10"
                                    :class="open ? 'border-sky-600 ring-4 ring-sky-700/10' : ''" aria-haspopup="listbox"
                                    :aria-expanded="open.toString()">
                                    <span class="min-w-0 truncate"
                                        :class="selected ? 'text-slate-950 font-bold' : 'text-slate-500'"
                                        x-text="selectedLabel">{{ $selectedServiceTypeLabel }}</span>
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
                                        <button type="button" @click="choose(@js($value), @js($label))"
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

                        <button type="submit" class="service-btn service-btn--red w-full text-base">
                            {{ __('ftherm.contact.send') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
