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
    $facebookUrl = 'https://www.facebook.com/people/FTherm/100094193259896/';
    $instagramUrl = 'https://www.instagram.com/ftherm.rs/';
    $trustItems = __('ftherm.trust.items');
    $fallbackFaqItems = __('ftherm.faq.items');
    $serviceTypes = __('ftherm.contact.service_types');
    $trustIcons = [
        'M9 12l2 2 4-5m5 3a8 8 0 11-16 0 8 8 0 0116 0z',
        'M8 7h8M8 11h8M8 15h5M5 3h14a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 012-2z',
        'M4 7h16M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2',
        'M13 2L4 14h7l-1 8 10-13h-7l0-7z',
    ];
@endphp

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@section('content')
    <div id="ftherm-page-loader" class="home-loader" aria-hidden="true">
        <div class="loader-unit">
            <div class="loader-logo">
                {!! file_get_contents(public_path('images/logo.svg')) !!}
            </div>
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

                    <div class="motion-reveal hidden gap-3 sm:grid sm:grid-cols-3" data-reveal style="--delay: 120ms">
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

                <div class="services-swiper swiper mt-10">
                    <div class="services-grid swiper-wrapper">
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
                        <article class="service-card swiper-slide motion-reveal group overflow-hidden" data-reveal
                            style="--delay: {{ ($index % 4) * 75 }}ms">
                            <img src="{{ $serviceImage }}" alt="{{ $serviceAlt }}"
                                class="h-40 w-full object-cover transition group-hover:scale-105" width="640"
                                height="420" loading="{{ $index < 2 ? 'eager' : 'lazy' }}">
                            <div class="service-card__body p-5">
                                <h3 class="text-lg font-black text-slate-950">{{ $serviceTitle }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $serviceDescription }}</p>
                                <a href="{{ $serviceUrl }}"
                                    class="service-card__cta inline-flex items-center gap-2 text-sm font-black text-sky-700 hover:text-[#DD2131]">
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
                            <article class="service-card swiper-slide motion-reveal overflow-hidden" data-reveal
                                style="--delay: {{ ($index % 4) * 75 }}ms">
                                <div class="service-card__body p-5">
                                    <h3 class="text-lg font-black text-slate-950">{{ $service['title'] }}</h3>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service['description'] }}</p>
                                    <a href="#contact"
                                        class="service-card__cta inline-flex items-center gap-2 text-sm font-black text-sky-700 hover:text-[#DD2131]">
                                        {{ __('ftherm.services.card_cta') }}
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                    </div>
                    <div class="services-slider-controls">
                        <div class="services-pagination" aria-label="Service slider pagination"></div>
                        <div class="services-navigation">
                            <button type="button" class="services-prev" aria-label="Previous service">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </button>
                            <button type="button" class="services-next" aria-label="Next service">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="seasonal-section premium-section py-16 md:py-24">
            <div class="seasonal-shell mx-auto grid max-w-[1200px] gap-0 overflow-hidden lg:grid-cols-2 lg:items-stretch">
                <div class="seasonal-media motion-reveal" data-reveal>
                    <img src="{{ asset('images/ftherm/service-ac-cleaning.webp') }}"
                        alt="{{ __('ftherm.services.items.2.alt') }}"
                        class="h-full min-h-[300px] w-full object-cover" width="900" height="506"
                        loading="lazy">
                </div>
                <div class="seasonal-content motion-reveal flex flex-col justify-center" data-reveal style="--delay: 120ms">
                    <p class="section-kicker">{{ __('ftherm.seasonal.eyebrow') }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.seasonal.title') }}</h2>
                    <p class="balanced-copy mt-5 text-base leading-8 text-slate-600 sm:text-lg">{{ __('ftherm.seasonal.text') }}</p>
                    <ul class="seasonal-benefits mt-7 grid gap-3 sm:grid-cols-2">
                        @foreach (__('ftherm.seasonal.bullets') as $bullet)
                            <li class="seasonal-benefit flex items-start gap-3">
                                <span class="seasonal-benefit__icon">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span class="font-bold text-slate-700">{{ $bullet }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="#contact"
                        class="ft-btn ft-btn-red mt-8 inline-flex w-full justify-center px-6 py-4 font-black text-white sm:w-fit">{{ __('ftherm.seasonal.cta') }}</a>
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
                    <a href="{{ route('references.index', ['locale' => current_locale()]) }}"
                        class="ft-btn hidden w-fit border border-slate-300 px-5 py-3 font-black text-slate-800 transition hover:bg-slate-950 hover:text-white md:inline-flex">{{ __('ftherm.gallery.cta') }}</a>
                </div>

                @if ($galleryAlbums->count())
                    <div class="references-swiper swiper mt-10">
                        <div class="references-home-grid swiper-wrapper">
                        @foreach ($galleryAlbums as $album)
                            <a href="{{ route('references.show', ['locale' => current_locale(), 'slug' => $album->slug]) }}"
                                class="reference-card swiper-slide motion-reveal group overflow-hidden" data-reveal
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
                        <div class="references-slider-controls">
                            <div class="references-pagination" aria-label="Reference slider pagination"></div>
                            <div class="references-navigation">
                                <button type="button" class="references-prev" aria-label="Previous reference">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </button>
                                <button type="button" class="references-next" aria-label="Next reference">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </button>
                            </div>
                        </div>
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
                <a href="{{ route('references.index', ['locale' => current_locale()]) }}"
                    class="ft-btn mt-7 inline-flex w-full justify-center border border-slate-300 px-5 py-3 font-black text-slate-800 transition hover:bg-slate-950 hover:text-white md:hidden">{{ __('ftherm.gallery.cta') }}</a>
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
            <div class="faq-layout mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="faq-intro motion-reveal" data-reveal>
                    <p class="section-kicker">{{ __('ftherm.faq.eyebrow') }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.faq.title') }}</h2>
                    <p class="mt-5 max-w-lg text-base leading-8 text-slate-600 sm:text-lg">{{ __('ftherm.faq.intro') }}</p>
                    <a href="#contact" class="faq-contact-link mt-7 inline-flex items-center gap-3 font-black">
                        <span>{{ __('ftherm.faq.contact') }}</span>
                        <span class="faq-contact-link__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14m-5-5 5 5-5 5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        </span>
                    </a>
                </div>
                <div class="faq-shell motion-reveal" x-data="{ open: 0 }" data-reveal style="--delay: 100ms">
                    @foreach ($displayFaqItems as $index => $item)
                        @php
                            $question = is_array($item) ? ($item['question'] ?? '') : translate($item->question ?? '');
                            $answer = is_array($item) ? ($item['answer'] ?? '') : translate($item->answer ?? '');
                        @endphp
                        <article class="faq-row" :class="open === {{ $index }} ? 'is-open' : ''">
                            <button type="button"
                                class="faq-trigger flex w-full items-center gap-4 text-left"
                                @click="open = open === {{ $index }} ? null : {{ $index }}"
                                :aria-expanded="(open === {{ $index }}).toString()"
                                aria-controls="faq-panel-{{ $index }}">
                                <span class="faq-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="faq-question flex-1">{{ $question }}</span>
                                <span class="faq-toggle" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" :class="open === {{ $index }} ? 'rotate-45' : ''"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round" /></svg>
                                </span>
                            </button>
                            <div x-cloak id="faq-panel-{{ $index }}" class="faq-answer"
                                :class="open === {{ $index }} ? 'is-open' : ''"
                                :aria-hidden="(open !== {{ $index }}).toString()">
                                <div class="faq-answer__inner">
                                    <p class="faq-answer-copy">{{ $answer }}</p>
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

                <div class="motion-reveal" data-reveal style="--delay: 120ms">
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

            if (window.Swiper && document.querySelector('.services-swiper')) {
                new Swiper('.services-swiper', {
                    slidesPerView: 1.48,
                    spaceBetween: 14,
                    speed: reduceMotion ? 0 : 550,
                    watchOverflow: true,
                    pagination: {
                        el: '.services-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.services-next',
                        prevEl: '.services-prev'
                    },
                    breakpoints: {
                        640: {
                            enabled: false,
                            slidesPerView: 2,
                            spaceBetween: 20
                        }
                    }
                });
            }

            if (window.Swiper && document.querySelector('.references-swiper')) {
                new Swiper('.references-swiper', {
                    slidesPerView: 1.48,
                    spaceBetween: 14,
                    speed: reduceMotion ? 0 : 550,
                    watchOverflow: true,
                    pagination: {
                        el: '.references-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.references-next',
                        prevEl: '.references-prev'
                    },
                    breakpoints: {
                        768: {
                            enabled: false,
                            slidesPerView: 3,
                            spaceBetween: 20
                        }
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
