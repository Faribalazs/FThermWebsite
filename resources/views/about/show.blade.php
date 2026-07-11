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
