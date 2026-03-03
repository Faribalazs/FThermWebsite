@extends('layouts.public')

@section('title', __('frontend.nav_home'))

@section('content')
    @if ($slides->count())
        <section class="py-4 sm:py-8 bg-white">
            <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
                <div class="hero-slider-wrap relative overflow-hidden rounded-2xl shadow-xl">
                    <div class="swiper hero-swiper w-full h-full">
                        <div class="swiper-wrapper">
                            @foreach ($slides as $slide)
                                @php
                                    // On sm+ screens honour the admin-chosen position; mobile is always bottom-center
                                    $posX = match ($slide->text_position_x) {
                                        'center' => 'sm:items-center sm:text-center',
                                        'right' => 'sm:items-end sm:text-right',
                                        default => 'sm:items-start sm:text-left',
                                    };
                                    $posY = match ($slide->text_position_y) {
                                        'top' => 'sm:justify-start sm:pt-32',
                                        'bottom' => 'sm:justify-end sm:pb-20',
                                        default => 'sm:justify-center',
                                    };
                                    $btnTitle = translate($slide->button_text);
                                    $imgSrc = str_starts_with($slide->image, 'images/')
                                        ? asset($slide->image)
                                        : Storage::url($slide->image);
                                @endphp
                                <div class="swiper-slide relative">
                                    <!-- Background image -->
                                    <img src="{{ $imgSrc }}" alt="{{ translate($slide->title) }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    <!-- Overlay — stronger gradient at bottom so text is always readable -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10">
                                    </div>
                                    <!-- Content — mobile: always bottom-center; sm+: admin-set position -->
                                    <div
                                        class="relative h-full max-w-[1440px] mx-auto px-4 lg:px-10 flex flex-col justify-end items-center text-center pb-14 sm:pb-0 {{ $posY }} {{ $posX }}">
                                        <div class="max-w-2xl w-full">
                                            @if (translate($slide->title))
                                                <h2
                                                    class="text-xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-2 sm:mb-4 drop-shadow-lg">
                                                    {{ translate($slide->title) }}
                                                </h2>
                                            @endif
                                            @if (translate($slide->description))
                                                <p
                                                    class="block text-sm sm:text-lg text-white/90 mb-4 sm:mb-6 leading-relaxed drop-shadow">
                                                    {{ translate($slide->description) }}
                                                </p>
                                            @endif
                                            @if ($btnTitle && $slide->button_link)
                                                <a href="{{ $slide->button_link }}"
                                                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-500 text-white font-bold px-5 py-2.5 sm:px-7 sm:py-3.5 text-sm sm:text-base rounded-xl transition-all shadow-lg hover:shadow-primary-600/40 hover:shadow-2xl group">
                                                    {{ $btnTitle }}
                                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="swiper-pagination hero-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
        <style>
            /* Responsive slider height */
            .hero-slider-wrap {
                height: clamp(450px, 55vw, 360px);
            }

            @media (min-width: 640px) {
                .hero-slider-wrap {
                    height: clamp(420px, 70vh, 820px);
                }
            }

            .hero-swiper-pagination {
                bottom: 10px !important;
            }

            @media (min-width: 640px) {
                .hero-swiper-pagination {
                    bottom: 24px !important;
                }
            }

            .hero-swiper .swiper-pagination-bullet {
                width: 8px;
                height: 8px;
                background: rgba(255, 255, 255, 0.55);
                opacity: 1;
                transition: background 0.3s, transform 0.3s;
            }

            @media (min-width: 640px) {
                .hero-swiper .swiper-pagination-bullet {
                    width: 14px;
                    height: 14px;
                }
            }

            .hero-swiper .swiper-pagination-bullet-active {
                background: #ffffff;
                transform: scale(1.35);
            }
        </style>

        @push('scripts')
            <script>
                // Hero swiper
                new Swiper('.hero-swiper', {
                    loop: true,
                    speed: 700,
                    autoplay: {
                        delay: 5500,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                });

                // Services swiper (mobile only)
                if (window.innerWidth < 768) {
                    new Swiper('.services-swiper', {
                        slidesPerView: 1.15,
                        spaceBetween: 14,
                        grabCursor: true,
                        navigation: {
                            prevEl: '.services-prev',
                            nextEl: '.services-next',
                        },
                        pagination: {
                            el: '.services-swiper-pagination',
                            clickable: true,
                        },
                    });
                }
            </script>
        @endpush
    @else
        <section
            class="relative bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 text-white overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-5"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary-900/50 to-transparent"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-10 w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl"></div>
            <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10 py-24 md:py-32 lg:py-40">
                <div class="max-w-3xl">
                    <div
                        class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium border border-white/10">
                        <span class="flex h-2 w-2 relative">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary-400"></span>
                        </span>
                        {{ __('frontend.hero_badge') }}
                    </div>
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-[1.1] tracking-tight">
                        {{ translate($hero['hero_title']->value ?? ['en' => 'Modern Heating Solutions']) }}
                    </h1>
                    <p class="text-lg md:text-xl text-primary-100/90 mb-10 leading-relaxed max-w-2xl">
                        {{ translate($hero['hero_subtitle']->value ?? ['en' => 'Professional installation of heat pumps and HVAC systems']) }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#contact"
                            class="inline-flex items-center justify-center bg-secondary-600 hover:bg-secondary-500 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-lg hover:shadow-secondary-500/25 hover:shadow-2xl group">
                            {{ translate($hero['hero_cta']->value ?? ['en' => 'Request Offer']) }}
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#services"
                            class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-bold px-8 py-4 rounded-xl transition border border-white/20 hover:border-white/30">
                            {{ __('frontend.hero_learn_more') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-12 md:h-20">
                    <path
                        d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z"
                        fill="white" />
                </svg>
            </div>
        </section>
    @endif

    <!-- Services Section -->
    <section id="services" class="sm:py-24 pt-10 bg-white relative">
        <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10">

            <div class="flex flex-col items-center text-center mb-16">
                <span
                    class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-xs font-extrabold uppercase tracking-widest mb-6">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                    {{ __('frontend.services_badge') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-5 leading-tight">
                    {{ __('frontend.services_title') }}
                </h2>
                <p class="text-lg text-gray-500 max-w-2xl leading-relaxed">{{ __('frontend.services_subtitle') }}</p>
            </div>

            {{-- Mobile Swiper (< md) --}}
            <div class="block md:hidden">
                <div class="swiper services-swiper overflow-visible">
                    <div class="swiper-wrapper">
                        @foreach ($services as $service)
                            <div class="swiper-slide h-auto">
                                <div
                                    class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm h-full overflow-hidden flex flex-col">
                                    <div
                                        class="absolute top-0 inset-x-0 h-0.5 bg-gradient-to-r from-primary-500 to-primary-400 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-400">
                                    </div>
                                    <div class="p-6 flex flex-col flex-1">
                                        <div
                                            class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 mb-5 bg-primary-50 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if ($service->icon)
                                                    {!! $service->icon !!}
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                @endif
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">
                                            {{ translate($service->title) }}</h3>
                                        <p class="text-gray-500 text-sm leading-relaxed flex-1">
                                            {{ translate($service->description) }}</p>
                                        <div
                                            class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2 text-sm font-semibold text-primary-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                            {{ __('frontend.hero_learn_more') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Navigation arrows below swiper --}}
                <div class="flex items-center justify-center gap-3 mt-6">
                    <button
                        class="services-prev w-11 h-11 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-600 hover:bg-primary-600 hover:border-primary-600 hover:text-white transition-all duration-200 hover:-translate-x-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <div class="services-swiper-pagination flex gap-1.5 items-center"></div>
                    <button
                        class="services-next w-11 h-11 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-600 hover:bg-primary-600 hover:border-primary-600 hover:text-white transition-all duration-200 hover:translate-x-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Desktop Grid (md+) --}}
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div
                        class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary-900/8 hover:border-primary-200/70 hover:-translate-y-1.5 transition-all duration-300 overflow-hidden flex flex-col">
                        <div
                            class="absolute top-0 inset-x-0 h-0.5 bg-gradient-to-r from-primary-500 to-primary-400 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-400">
                        </div>
                        <div class="p-7 flex flex-col flex-1">
                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 mb-6 bg-primary-50 text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($service->icon)
                                        {!! $service->icon !!}
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    @endif
                                </svg>
                            </div>
                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-700 transition-colors leading-snug">
                                {{ translate($service->title) }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ translate($service->description) }}
                            </p>
                            <div
                                class="mt-5 pt-5 border-t border-gray-100 flex items-center gap-2 text-sm font-semibold text-primary-600 opacity-70 group-hover:opacity-100 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                {{ __('frontend.hero_learn_more') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <style>
        .services-swiper-pagination .swiper-pagination-bullet {
            width: 6px;
            height: 6px;
            background: #cbd5e1;
            opacity: 1;
            border-radius: 9999px;
            transition: background 0.2s, width 0.2s;
            display: inline-block;
        }

        .services-swiper-pagination .swiper-pagination-bullet-active {
            background: #0873c7;
            width: 18px;
            border-radius: 9999px;
        }
    </style>

    <!-- Featured Products Section -->
    <section class="py-20 md:py-28 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
                <div>
                    <span
                        class="inline-block px-4 py-1.5 bg-primary-50 text-primary-700 rounded-full text-xs font-bold uppercase tracking-wider mb-4">{{ __('frontend.products_badge') }}</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
                        {{ __('frontend.products_title') }}</h2>
                    <p class="text-lg text-gray-500 max-w-xl">{{ __('frontend.products_subtitle') }}</p>
                </div>
                <a href="{{ route('shop.index') }}"
                    class="hidden md:inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition shadow-sm hover:shadow-md group flex-shrink-0">
                    {{ __('frontend.products_view_all') }}
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($featured_products as $product)
                    <a href="{{ route('shop.show', $product) }}"
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                        @if ($product->primaryImage)
                            <div class="relative overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                    alt="{{ translate($product->name) }}"
                                    class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                            </div>
                        @else
                            <div
                                class="h-56 bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-700 transition-colors line-clamp-2">
                                {{ translate($product->name) }}</h3>
                            @if ($product->price)
                                <div class="flex items-baseline gap-1.5">
                                    <span
                                        class="text-2xl font-bold text-primary-600">{{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm text-gray-400 font-medium">RSD</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-10 md:hidden">
                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-4 rounded-xl transition shadow-lg">
                    {{ __('frontend.products_view_all') }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section
        class="py-20 md:py-28 bg-gradient-to-br from-primary-800 via-primary-900 to-gray-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-secondary-500/10 rounded-full blur-3xl"></div>
        <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider mb-4">{{ __('frontend.why_badge') }}</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">{{ __('frontend.why_title') }}</h2>
                <p class="text-lg text-primary-100/80 max-w-2xl mx-auto">{{ __('frontend.why_subtitle') }}</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="text-center group p-6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ __('frontend.why_experience') }}</h3>
                    <p class="text-primary-100/70 text-sm leading-relaxed">{{ __('frontend.why_experience_desc') }}</p>
                </div>
                <div class="text-center group p-6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ __('frontend.why_installation') }}</h3>
                    <p class="text-primary-100/70 text-sm leading-relaxed">{{ __('frontend.why_installation_desc') }}</p>
                </div>
                <div class="text-center group p-6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ __('frontend.why_efficiency') }}</h3>
                    <p class="text-primary-100/70 text-sm leading-relaxed">{{ __('frontend.why_efficiency_desc') }}</p>
                </div>
                <div class="text-center group p-6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ __('frontend.why_warranty') }}</h3>
                    <p class="text-primary-100/70 text-sm leading-relaxed">{{ __('frontend.why_warranty_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 md:py-28 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
            <div class="text-center mb-14">
                <span
                    class="inline-block px-4 py-1.5 bg-primary-50 text-primary-700 rounded-full text-xs font-bold uppercase tracking-wider mb-4">{{ __('frontend.contact_badge') }}</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    {{ __('frontend.contact_title') }}</h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">{{ __('frontend.contact_subtitle') }}</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16">
                <!-- Contact Form -->
                <div class="lg:col-span-3">
                    @if (session('success'))
                        <div
                            class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name"
                                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_name') }}
                                    <span class="text-secondary-500">*</span></label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('frontend.contact_name_placeholder') }}">
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_email') }}
                                    <span class="text-secondary-500">*</span></label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm"
                                    value="{{ old('email') }}"
                                    placeholder="{{ __('frontend.contact_email_placeholder') }}">
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="phone"
                                class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_phone') }}</label>
                            <input type="text" id="phone" name="phone"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm"
                                value="{{ old('phone') }}"
                                placeholder="{{ __('frontend.contact_phone_placeholder') }}">
                            @error('phone')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label for="message"
                                class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_message') }}
                                <span class="text-secondary-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition resize-none text-sm"
                                placeholder="{{ __('frontend.contact_message_placeholder') }}">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 group">
                            <span>{{ __('frontend.contact_send') }}</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Contact Info Sidebar -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 rounded-2xl p-7 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-5">{{ __('frontend.contact_info_title') }}</h3>
                        <div class="space-y-5">
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 transition">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-1">
                                        {{ __('frontend.contact_phone_label') }}</p>
                                    <a href="tel:0641391360"
                                        class="text-gray-900 hover:text-primary-600 font-semibold transition text-sm">064
                                        139 1360</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-10 h-10 bg-secondary-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-secondary-100 transition">
                                    <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-1">
                                        {{ __('frontend.contact_email_label') }}</p>
                                    <a href="mailto:farkas.tibor@ftherm.rs"
                                        class="text-gray-900 hover:text-primary-600 font-semibold transition text-sm break-all">farkas.tibor@ftherm.rs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-primary-50 rounded-2xl p-7 border border-primary-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('frontend.contact_hours_title') }}
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">{{ __('frontend.contact_weekdays') }}</span>
                                <span class="text-primary-700 font-bold">08:00 - 18:00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">{{ __('frontend.contact_saturday') }}</span>
                                <span class="text-primary-700 font-bold">09:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">{{ __('frontend.contact_sunday') }}</span>
                                <span class="text-secondary-600 font-bold">{{ __('frontend.contact_closed') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
