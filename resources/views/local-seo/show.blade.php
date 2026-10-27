@extends('layouts.public')

@php
    $heroImage = $page['type'] === 'heat-pumps'
        ? asset('images/ftherm/service-pages/heat-pumps.png')
        : asset('images/ftherm/service-pages/air-conditioning-installation.png');
    $companyPhone = setting_value('company_phone');
    $telHref = $companyPhone ? 'tel:' . preg_replace('/[^\d+]/', '', $companyPhone) : null;
    $sectionCopy = match (current_locale()) {
        'hu' => [
            'process' => 'Hogyan segítünk',
            'process_intro' => 'A felméréstől és tervezéstől a kivitelezésig minden lépést érthetően és az épület valós igényeihez igazítva végzünk.',
            'faq_intro' => 'A Szabadkán és környékén végzett munkákkal kapcsolatos leggyakoribb kérdések.',
            'area' => 'Szabadka • Palics • környéke',
        ],
        'en' => [
            'process' => 'How we can help',
            'process_intro' => 'From assessment and planning to installation, every step is clear and tailored to the building’s actual requirements.',
            'faq_intro' => 'Answers to common questions about our work in Subotica and nearby areas.',
            'area' => 'Subotica • Palić • nearby areas',
        ],
        default => [
            'process' => 'Kako možemo da pomognemo',
            'process_intro' => 'Od procene i planiranja do ugradnje, svaki korak je jasan i prilagođen stvarnim potrebama objekta.',
            'faq_intro' => 'Odgovori na najčešća pitanja o našim uslugama u Subotici i okolini.',
            'area' => 'Subotica • Palić • okolina',
        ],
    };
@endphp

@section('title', $page['title'])
@section('meta_description', $page['description'])
@section('meta_keywords', $page['keywords'] ?? ($page['eyebrow'] . ', FTHERM Subotica'))
@section('og_image', $heroImage)

@push('head')
    <script type="application/ld+json">{!! json_encode([
        chr(64).'context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => url()->current() . '#service',
        'name' => $page['serviceName'],
        'description' => $page['description'],
        'image' => $heroImage,
        'url' => url()->current(),
        'areaServed' => [
            ['@type' => 'City', 'name' => 'Subotica'],
            ['@type' => 'Place', 'name' => 'Palić'],
            ['@type' => 'AdministrativeArea', 'name' => 'Severnobački okrug'],
        ],
        'provider' => ['@id' => url('/#organization')],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode([
        chr(64).'context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($page['faqs'])->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
        ])->values()->all(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <article class="local-seo-page service-page">
        <header class="service-hero local-seo-hero">
            <img src="{{ $heroImage }}" alt="{{ $page['heading'] }}" class="service-hero__image" width="1672"
                height="941" fetchpriority="high">
            <div class="service-hero__overlay"></div>
            <div class="service-container service-hero__inner">
                <div>
                    <p class="service-kicker">{{ $page['eyebrow'] }}</p>
                    <h1 class="service-title mt-5 text-4xl font-black leading-tight sm:text-5xl lg:text-7xl">
                        {{ $page['heading'] }}
                    </h1>
                    <p class="service-hero-copy mt-6 text-base leading-8 sm:text-lg">{{ $page['intro'] }}</p>
                    <p class="local-seo-area mt-6">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $sectionCopy['area'] }}
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#contact" class="service-btn service-btn--red">{{ __('ftherm.cta.quote') }}</a>
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#services"
                            class="service-btn service-btn--ghost">{{ __('ftherm.services.all_services') }}</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="local-seo-benefits-section">
            <div class="service-container">
                <div class="local-seo-benefits-grid">
                    @foreach ($page['benefits'] as $benefit)
                        <article class="local-seo-benefit-card">
                            <span class="local-seo-benefit-card__icon" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <p>{{ $benefit }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="local-seo-content-section py-16 md:py-24">
            <div class="service-container">
                <div class="max-w-3xl">
                    <p class="service-section-kicker">{{ $page['eyebrow'] }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ $sectionCopy['process'] }}</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-600">{{ $sectionCopy['process_intro'] }}</p>
                </div>

                <div class="local-seo-content-grid mt-10">
                    @foreach ($page['sections'] as $section)
                        <article class="local-seo-content-card">
                            <div class="local-seo-content-card__topline">
                                <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3>{{ $section['title'] }}</h3>
                            <p>{{ $section['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="local-seo-faq-section py-16 md:py-24">
            <div class="service-container grid gap-10 lg:grid-cols-[0.78fr_1.22fr] lg:items-start">
                <div class="lg:sticky lg:top-32">
                    <p class="service-section-kicker">{{ $page['eyebrow'] }}</p>
                    <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.nav.faq') }}</h2>
                    <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">{{ $sectionCopy['faq_intro'] }}</p>
                </div>

                <div class="local-seo-faq-list">
                    @foreach ($page['faqs'] as $faq)
                        <details class="local-seo-faq-item" @if ($loop->first) open @endif>
                            <summary>
                                <span>{{ $faq['q'] }}</span>
                                <span class="local-seo-faq-item__icon" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12" />
                                    </svg>
                                </span>
                            </summary>
                            <p>{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="local-seo-cta-section py-16 md:py-24">
            <div class="service-container">
                <div class="local-seo-cta-card">
                    <div class="relative z-10 max-w-3xl">
                        <p class="service-kicker">{{ __('ftherm.services.next_step_eyebrow') }}</p>
                        <h2 class="mt-4 text-3xl font-black text-white sm:text-5xl">{{ __('ftherm.services.next_step_title') }}</h2>
                        <p class="mt-5 text-lg leading-8 text-sky-100">{{ __('ftherm.services.next_step_text') }}</p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('home', ['locale' => current_locale()]) }}#contact"
                                class="service-btn service-btn--red">{{ __('ftherm.cta.quote') }}</a>
                            @if ($companyPhone)
                                <a href="{{ $telHref }}" class="service-btn service-btn--ghost">{{ $companyPhone }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
