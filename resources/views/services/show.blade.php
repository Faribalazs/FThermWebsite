@extends('layouts.public')

@php
    $title = translate($service->title);
    $description = translate($service->description);
    $content = translate($service->content) ?: '<p>' . e($description) . '</p>';
    $image = $service->image
        ? (str_starts_with($service->image, 'images/') ? asset($service->image) : Storage::url($service->image))
        : asset('images/ftherm/hero-ftherm-technician-ac-installation.webp');
    $imageAlt = translate($service->image_alt) ?: $title;
@endphp

@section('title', $title . ' | FTHERM')
@section('meta_description', Str::limit(strip_tags($description), 155))
@section('og_image', $image)

@push('head')
    <style>
        .service-page {
            --ft-navy: #071527;
            --ft-blue: #09539a;
            --ft-blue-soft: #0c93ea;
            --ft-red: #dd2131;
            color: #0f172a;
            background: #ffffff;
        }

        .service-hero {
            min-height: clamp(560px, 74vh, 780px);
            background: var(--ft-navy);
        }

        .service-hero__image {
            filter: saturate(1.08) contrast(1.04) brightness(0.82);
        }

        .service-hero__overlay {
            background:
                linear-gradient(90deg, rgba(7, 21, 39, 0.9) 0%, rgba(7, 21, 39, 0.64) 42%, rgba(7, 21, 39, 0.12) 100%),
                linear-gradient(180deg, rgba(7, 21, 39, 0.18), rgba(7, 21, 39, 0.76));
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

        .service-body {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #475569;
        }

        .service-body h2,
        .service-body h3 {
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: #0f172a;
            font-weight: 900;
            line-height: 1.18;
        }

        .service-body h2 {
            font-size: clamp(1.75rem, 3vw, 2.5rem);
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

        .service-panel {
            border-radius: 8px;
            border: 1px solid #dbeafe;
            background:
                linear-gradient(135deg, rgba(9, 83, 154, 0.08), rgba(103, 232, 249, 0.08)),
                #ffffff;
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="service-page">
        <section class="service-hero relative isolate overflow-hidden text-white">
            <img src="{{ $image }}" alt="{{ $imageAlt }}" class="service-hero__image absolute inset-0 h-full w-full object-cover" width="1800" height="1013" fetchpriority="high">
            <div class="service-hero__overlay absolute inset-0"></div>
            <div class="relative z-10 mx-auto flex min-h-[inherit] max-w-[1440px] items-end px-4 pb-16 pt-40 lg:px-10 lg:pb-24">
                <div class="max-w-3xl">
                    <a href="{{ route('home') }}#services" class="service-kicker">{{ __('ftherm.services.back') }}</a>
                    <h1 class="mt-5 text-4xl font-black leading-tight sm:text-5xl lg:text-7xl">{{ $title }}</h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">{{ $description }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#contact" class="inline-flex items-center justify-center rounded-md bg-[#DD2131] px-6 py-4 font-black text-white shadow-lg shadow-red-950/20 transition hover:bg-[#bf1d2b]">
                            {{ __('ftherm.cta.quote') }}
                        </a>
                        <a href="{{ route('home') }}#services" class="inline-flex items-center justify-center rounded-md border border-white/25 bg-white/10 px-6 py-4 font-black text-white backdrop-blur transition hover:bg-white/16">
                            {{ __('ftherm.services.all_services') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 md:py-24">
            <div class="mx-auto grid max-w-[1180px] gap-10 px-4 lg:grid-cols-[1fr_320px] lg:px-10">
                <article class="service-body">
                    {!! $content !!}
                </article>

                <aside class="space-y-5">
                    <div class="service-panel p-6">
                        <p class="text-sm font-black uppercase text-sky-700">{{ __('ftherm.services.next_step_eyebrow') }}</p>
                        <h2 class="mt-3 text-2xl font-black text-slate-950">{{ __('ftherm.services.next_step_title') }}</h2>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ __('ftherm.services.next_step_text') }}</p>
                        <a href="#contact" class="mt-5 inline-flex w-full items-center justify-center rounded-md bg-slate-950 px-5 py-3 text-sm font-black text-white transition hover:bg-sky-800">
                            {{ __('ftherm.cta.quote') }}
                        </a>
                    </div>

                    @if ($relatedServices->isNotEmpty())
                        <div class="service-panel p-6">
                            <h2 class="text-lg font-black text-slate-950">{{ __('ftherm.services.related') }}</h2>
                            <div class="mt-4 space-y-3">
                                @foreach ($relatedServices as $related)
                                    <a href="{{ route('services.show', ['service' => $related->slug]) }}" class="block border-t border-sky-100 pt-3 text-sm font-black text-slate-700 transition hover:text-sky-700">
                                        {{ translate($related->title) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </section>

        <section id="contact" class="bg-slate-950 py-16 text-white md:py-20">
            <div class="mx-auto flex max-w-[1180px] flex-col gap-6 px-4 lg:flex-row lg:items-center lg:justify-between lg:px-10">
                <div>
                    <p class="service-kicker">{{ __('ftherm.contact.eyebrow') }}</p>
                    <h2 class="mt-4 text-3xl font-black sm:text-5xl">{{ __('ftherm.contact.title') }}</h2>
                    <p class="mt-4 max-w-2xl text-slate-300">{{ __('ftherm.contact.intro') }}</p>
                </div>
                <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center rounded-md bg-[#DD2131] px-6 py-4 font-black text-white transition hover:bg-[#bf1d2b]">
                    {{ __('ftherm.cta.quote') }}
                </a>
            </div>
        </section>
    </div>
@endsection
