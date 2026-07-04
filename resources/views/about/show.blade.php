@extends('layouts.public')

@php
    $imageUrl = function (?string $path, string $fallback): string {
        if (!$path) {
            return asset($fallback);
        }

        return str_starts_with($path, 'images/') ? asset($path) : Storage::url($path);
    };

    $heroImage = $imageUrl($aboutPage->hero_image, 'images/ftherm/about/ftherm-about-hero-team.png');
    $secondaryImage = $imageUrl($aboutPage->secondary_image, 'images/ftherm/about/ftherm-about-technical-detail.png');
    $pageTitle = translate($aboutPage->seo_title) ?: translate($aboutPage->title) . ' - FTHERM';
    $pageDescription = translate($aboutPage->seo_description) ?: translate($aboutPage->intro);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDescription)
@section('og_image', $heroImage)

@push('head')
    <style>
        .about-page {
            --ft-navy: #071527;
            --ft-blue: #09539a;
            --ft-blue-soft: #0c93ea;
            --ft-red: #dd2131;
            --ft-cyan: #67e8f9;
            color: #0f172a;
            background: #ffffff;
        }

        .about-hero {
            position: relative;
            min-height: clamp(720px, 88vh, 940px);
            overflow: hidden;
            background: var(--ft-navy);
            color: #ffffff;
            padding-top: clamp(8rem, 12vw, 12rem);
        }

        .about-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background:
                linear-gradient(90deg, rgba(7, 21, 39, 0.92) 0%, rgba(7, 21, 39, 0.66) 39%, rgba(7, 21, 39, 0.16) 100%),
                radial-gradient(circle at 18% 84%, rgba(221, 33, 49, 0.22), transparent 28%),
                radial-gradient(circle at 78% 20%, rgba(12, 147, 234, 0.22), transparent 30%);
            pointer-events: none;
        }

        .about-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 80px 80px;
            mask-image: linear-gradient(90deg, #000 0%, transparent 70%);
            opacity: 0.15;
            pointer-events: none;
        }

        .about-hero__image {
            filter: saturate(1.08) contrast(1.05);
        }

        .about-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0;
            text-transform: uppercase;
            color: #bdefff;
        }

        .about-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ft-red);
        }

        .about-kicker--dark {
            color: var(--ft-blue);
        }

        .about-title {
            text-wrap: balance;
            text-shadow: 0 24px 72px rgba(0, 0, 0, 0.34);
        }

        .about-copy {
            text-wrap: pretty;
        }

        .about-stat,
        .about-value-card,
        .about-panel {
            border-radius: 8px;
        }

        .about-stat {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(18px);
        }

        .about-richtext p + p {
            margin-top: 1.25rem;
        }

        .about-value-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(9, 83, 154, 0.14);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(240, 249, 255, 0.74)),
                #ffffff;
            box-shadow: 0 18px 50px rgba(7, 21, 39, 0.08);
        }

        .about-value-card::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--ft-blue), var(--ft-blue-soft), var(--ft-red));
        }

        .about-panel {
            border: 1px solid rgba(9, 83, 154, 0.12);
            background: #ffffff;
            box-shadow: 0 20px 55px rgba(7, 21, 39, 0.08);
        }

        .about-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.65s ease, transform 0.65s ease;
            transition-delay: var(--delay, 0ms);
        }

        .about-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .about-reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="about-page">
        <section class="about-hero">
            <img src="{{ $heroImage }}" alt="{{ translate($aboutPage->hero_image_alt) }}" class="about-hero__image absolute inset-0 h-full w-full object-cover" width="1672" height="941" loading="eager">
            <div class="relative z-10 mx-auto flex min-h-[inherit] max-w-[1440px] flex-col justify-center px-4 pb-16 lg:px-10">
                <div class="max-w-3xl about-reveal" data-about-reveal>
                    <p class="about-kicker">{{ translate($aboutPage->eyebrow) }}</p>
                    <h1 class="about-title mt-5 text-4xl font-black leading-tight sm:text-6xl lg:text-7xl">{{ translate($aboutPage->title) }}</h1>
                    <p class="about-copy mt-7 max-w-2xl text-lg leading-8 text-slate-200 sm:text-xl">{{ translate($aboutPage->intro) }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#contact" class="inline-flex justify-center rounded bg-[#DD2131] px-6 py-4 font-black text-white shadow-lg shadow-red-950/20 transition hover:bg-red-700">{{ __('ftherm.cta.quote') }}</a>
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#services" class="inline-flex justify-center rounded border border-white/25 bg-white/10 px-6 py-4 font-black text-white backdrop-blur transition hover:bg-white/16">{{ __('ftherm.cta.services') }}</a>
                    </div>
                </div>

                <div class="mt-12 grid gap-4 sm:grid-cols-3 lg:max-w-3xl">
                    @foreach ($aboutPage->stats ?? [] as $index => $stat)
                        <div class="about-stat about-reveal p-5" data-about-reveal style="--delay: {{ 100 + ($index * 80) }}ms">
                            <p class="text-3xl font-black text-white">{{ $stat['value'] ?? '' }}</p>
                            <p class="mt-2 text-xs font-black uppercase text-sky-100">{{ translate($stat['label'] ?? []) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24">
            <div class="mx-auto grid max-w-[1440px] gap-10 px-4 lg:grid-cols-[0.9fr_1.1fr] lg:px-10">
                <div class="about-reveal flex flex-col justify-center" data-about-reveal>
                    <p class="about-kicker about-kicker--dark">{{ translate($aboutPage->eyebrow) }}</p>
                    <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-5xl">{{ translate($aboutPage->secondary_title) }}</h2>
                    <div class="about-richtext about-copy mt-7 text-lg leading-8 text-slate-700">
                        {!! translate($aboutPage->body) !!}
                    </div>
                </div>
                <div class="about-panel about-reveal overflow-hidden p-2" data-about-reveal style="--delay: 120ms">
                    <img src="{{ $secondaryImage }}" alt="{{ translate($aboutPage->secondary_image_alt) }}" class="h-full min-h-[430px] w-full rounded object-cover" width="1448" height="1086" loading="lazy">
                </div>
            </div>
        </section>

        <section class="bg-slate-950 py-16 text-white md:py-24">
            <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="about-reveal max-w-3xl" data-about-reveal>
                    <p class="about-kicker">{{ __('ftherm.nav.about') }}</p>
                    <h2 class="mt-4 text-3xl font-black sm:text-5xl">{{ translate($aboutPage->values_title) }}</h2>
                    <p class="about-copy mt-5 text-lg leading-8 text-slate-300">{{ translate($aboutPage->secondary_body) }}</p>
                </div>

                <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ($aboutPage->values ?? [] as $index => $value)
                        <article class="about-value-card about-reveal p-6 text-slate-950" data-about-reveal style="--delay: {{ ($index % 4) * 80 }}ms">
                            <p class="text-5xl font-black text-slate-200">0{{ $loop->iteration }}</p>
                            <h3 class="mt-8 text-xl font-black">{{ translate($value['title'] ?? []) }}</h3>
                            <p class="about-copy mt-4 text-sm leading-6 text-slate-600">{{ translate($value['text'] ?? []) }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24">
            <div class="mx-auto max-w-[1440px] px-4 lg:px-10">
                <div class="about-panel about-reveal grid gap-8 overflow-hidden bg-white p-6 md:grid-cols-[1.1fr_0.9fr] md:p-10" data-about-reveal>
                    <div>
                        <p class="about-kicker about-kicker--dark">{{ __('ftherm.nav.about') }}</p>
                        <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-5xl">{{ __('ftherm.final_cta.title') }}</h2>
                        <p class="about-copy mt-5 text-lg leading-8 text-slate-600">{{ __('ftherm.final_cta.text') }}</p>
                    </div>
                    <div class="flex items-center md:justify-end">
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#contact" class="inline-flex rounded bg-[#09539A] px-7 py-4 font-black text-white shadow-lg shadow-sky-950/20 transition hover:bg-sky-700">{{ __('ftherm.cta.quote') }}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('[data-about-reveal]');

            if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                items.forEach(function(item) {
                    item.classList.add('is-visible');
                });
                return;
            }

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.16,
                rootMargin: '0px 0px -8% 0px'
            });

            items.forEach(function(item) {
                observer.observe(item);
            });
        });
    </script>
@endpush
