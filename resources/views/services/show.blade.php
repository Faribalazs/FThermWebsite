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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
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
                    <div class="service-related-swiper swiper">
                        <div class="service-related-grid swiper-wrapper">
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
                                class="service-related-card swiper-slide">
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
                        <div class="service-related-controls">
                            <div class="service-related-pagination" aria-label="Related services pagination"></div>
                            <div class="service-related-navigation">
                                <button type="button" class="service-related-prev" aria-label="Previous service">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </button>
                                <button type="button" class="service-related-next" aria-label="Next service">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </button>
                            </div>
                        </div>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Swiper || !document.querySelector('.service-related-swiper') || !window.matchMedia('(max-width: 640px)').matches) return;

            new Swiper('.service-related-swiper', {
                slidesPerView: 1.48,
                spaceBetween: 14,
                speed: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 550,
                watchOverflow: true,
                pagination: {
                    el: '.service-related-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.service-related-next',
                    prevEl: '.service-related-prev'
                }
            });
        });
    </script>
@endpush
