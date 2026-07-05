@extends('layouts.public')

@section('title', translate($album->title) . ' - FTHERM')
@section('meta_description', translate($album->description) ?: __('frontend.gallery_subtitle'))

@push('head')
    <style>
        .reference-detail {
            --ref-navy: #071527;
            --ref-blue: #09539a;
            --ref-blue-soft: #0c93ea;
            --ref-red: #dd2131;
            --ref-ink: #0f172a;
            --ref-muted: #64748b;
            background: #ffffff;
            color: var(--ref-ink);
        }

        .reference-detail-container {
            width: min(1440px, calc(100% - 2rem));
            margin-inline: auto;
        }

        .reference-detail-hero {
            position: relative;
            isolation: isolate;
            min-height: clamp(470px, 64vh, 660px);
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(7, 21, 39, 0.98), rgba(9, 83, 154, 0.94)),
                #071527;
            color: #ffffff;
        }

        .reference-detail-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.065) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.065) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: linear-gradient(90deg, #000 0%, transparent 78%);
            opacity: 0.18;
            pointer-events: none;
        }

        .reference-detail-hero__image {
            position: absolute;
            inset: 0;
            z-index: -2;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 1;
            filter: saturate(1.14) contrast(1.05) brightness(1.04);
        }

        .reference-detail-hero__shade {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(circle at 78% 34%, rgba(9, 83, 154, 0.1), transparent 34%),
                radial-gradient(circle at 18% 78%, rgba(221, 33, 49, 0.08), transparent 32%),
                linear-gradient(90deg, rgba(7, 21, 39, 0.72) 0%, rgba(7, 21, 39, 0.44) 38%, rgba(7, 21, 39, 0.08) 100%),
                linear-gradient(180deg, rgba(7, 21, 39, 0.02), rgba(7, 21, 39, 0.24));
        }

        .reference-detail-hero__inner {
            display: grid;
            min-height: inherit;
            align-items: center;
            padding-block: clamp(9rem, 16vw, 12rem) clamp(4rem, 8vw, 6.5rem);
        }

        .reference-detail-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: #bdefff;
            font-size: 0.82rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .reference-detail-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ref-red);
        }

        .reference-detail-title {
            margin-top: 1rem;
            max-width: 920px;
            font-size: clamp(2.35rem, 6vw, 5rem);
            font-weight: 950;
            line-height: 0.98;
            text-wrap: balance;
        }

        .reference-detail-lead {
            margin-top: 1.2rem;
            max-width: 760px;
            color: #dbeafe;
            font-size: clamp(1rem, 1.8vw, 1.15rem);
            line-height: 1.8;
            text-wrap: pretty;
        }

        .reference-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .reference-detail-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.7rem 0.95rem;
            color: #e0f2fe;
            font-weight: 900;
            backdrop-filter: blur(14px);
        }

        .reference-gallery-section {
            padding-block: clamp(3.5rem, 8vw, 6rem);
            background: #ffffff;
        }

        .reference-gallery-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: clamp(1.8rem, 4vw, 2.8rem);
        }

        .reference-gallery-head h2 {
            max-width: 720px;
            font-size: clamp(2rem, 4vw, 3.25rem);
            font-weight: 950;
            line-height: 1.04;
            text-wrap: balance;
        }

        .reference-back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 1px solid rgba(9, 83, 154, 0.18);
            border-radius: 999px;
            background: #ffffff;
            padding: 0.82rem 1rem;
            color: var(--ref-blue);
            font-size: 0.9rem;
            font-weight: 950;
            box-shadow: 0 12px 30px rgba(7, 21, 39, 0.06);
            transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }

        .reference-back-link:hover {
            transform: translateY(-2px);
            border-color: rgba(9, 83, 154, 0.3);
            background: #f0f9ff;
        }

        .reference-photo-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-auto-flow: dense;
            gap: 0.8rem;
        }

        .reference-photo {
            position: relative;
            display: block;
            min-height: 0;
            overflow: hidden;
            border: 1px solid rgba(9, 83, 154, 0.12);
            border-radius: 8px;
            aspect-ratio: 1;
            background: #eef6ff;
            cursor: pointer;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .reference-photo:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }

        .reference-photo:nth-child(6n) {
            grid-column: span 2;
            aspect-ratio: 2.05;
        }

        .reference-photo:hover {
            transform: translateY(-3px);
            border-color: rgba(9, 83, 154, 0.28);
            box-shadow: 0 24px 54px rgba(7, 21, 39, 0.12);
        }

        .reference-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .reference-photo:hover img {
            transform: scale(1.06);
        }

        .reference-photo__overlay {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            background: rgba(7, 21, 39, 0);
            color: #ffffff;
            transition: background 0.2s ease;
        }

        .reference-photo__icon {
            display: grid;
            width: 2.65rem;
            height: 2.65rem;
            place-items: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: var(--ref-navy);
            opacity: 0;
            transform: scale(0.82);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .reference-photo:hover .reference-photo__overlay {
            background: rgba(7, 21, 39, 0.28);
        }

        .reference-photo:hover .reference-photo__icon {
            opacity: 1;
            transform: scale(1);
        }

        .reference-empty {
            display: grid;
            min-height: 260px;
            place-items: center;
            border: 1px solid rgba(9, 83, 154, 0.12);
            border-radius: 8px;
            background: #f8fbff;
            color: var(--ref-muted);
            font-weight: 800;
            text-align: center;
        }

        .reference-lightbox {
            position: fixed;
            inset: 0;
            z-index: 90;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(2, 6, 23, 0.94);
            backdrop-filter: blur(14px);
        }

        .reference-lightbox__button,
        .reference-lightbox__close {
            display: inline-grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transition: background 0.18s ease, transform 0.18s ease, border-color 0.18s ease;
        }

        .reference-lightbox__button:hover,
        .reference-lightbox__close:hover {
            transform: translateY(-1px);
            border-color: rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.16);
        }

        .reference-lightbox__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 2.75rem;
            height: 2.75rem;
        }

        .reference-lightbox__button {
            position: absolute;
            top: 50%;
            width: 3rem;
            height: 3rem;
            transform: translateY(-50%);
        }

        .reference-lightbox__button:hover {
            transform: translateY(calc(-50% - 1px));
        }

        .reference-lightbox__button--prev {
            left: clamp(0.75rem, 3vw, 2rem);
        }

        .reference-lightbox__button--next {
            right: clamp(0.75rem, 3vw, 2rem);
        }

        .reference-lightbox__counter {
            position: absolute;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.45rem 0.8rem;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .reference-lightbox__stage {
            max-width: min(1100px, calc(100vw - 7rem));
            max-height: 82vh;
        }

        .reference-lightbox__stage img {
            display: block;
            max-width: 100%;
            max-height: 82vh;
            border-radius: 8px;
            object-fit: contain;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.45);
            user-select: none;
        }

        .reference-thumbs {
            position: absolute;
            right: 1rem;
            bottom: 1rem;
            left: 1rem;
            display: flex;
            justify-content: center;
            gap: 0.4rem;
            overflow-x: auto;
            padding: 0.45rem;
        }

        .reference-thumb {
            width: 3rem;
            height: 3rem;
            flex: 0 0 auto;
            overflow: hidden;
            border: 2px solid transparent;
            border-radius: 8px;
            opacity: 0.58;
            transition: opacity 0.18s ease, border-color 0.18s ease;
        }

        .reference-thumb.is-active {
            border-color: #ffffff;
            opacity: 1;
        }

        .reference-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 1024px) {
            .reference-photo-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .reference-detail-container {
                width: min(1440px, calc(100% - 32px));
            }

            .reference-detail-hero {
                min-height: 560px;
            }

            .reference-gallery-head {
                display: block;
            }

            .reference-back-link {
                margin-top: 1rem;
            }

            .reference-photo-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.55rem;
            }

            .reference-photo:first-child,
            .reference-photo:nth-child(6n) {
                grid-column: span 2;
            }

            .reference-lightbox__stage {
                max-width: calc(100vw - 2rem);
            }

            .reference-lightbox__button {
                top: auto;
                bottom: 5.25rem;
                transform: none;
            }

            .reference-lightbox__button:hover {
                transform: translateY(-1px);
            }
        }
    </style>
@endpush

@section('content')
    @php
        $heroImage = $album->images->first();
        $albumTitle = translate($album->title);
        $albumDescription = translate($album->description);
    @endphp

    <main class="reference-detail" x-data="galleryLightbox()"
        x-on:keydown.escape.window="close()"
        x-on:keydown.arrow-left.window="prev()"
        x-on:keydown.arrow-right.window="next()">
        <section class="reference-detail-hero">
            @if ($heroImage)
                <img src="{{ Storage::url($heroImage->path) }}" alt="{{ $albumTitle }}"
                    class="reference-detail-hero__image">
                <div class="reference-detail-hero__shade"></div>
            @endif
            <div class="reference-detail-container reference-detail-hero__inner">
                <div>
                    <p class="reference-detail-kicker">{{ __('frontend.gallery_badge') }}</p>
                    <h1 class="reference-detail-title">{{ $albumTitle }}</h1>
                    @if ($albumDescription)
                        <p class="reference-detail-lead">{{ $albumDescription }}</p>
                    @endif
                    <div class="reference-detail-meta">
                        <span class="reference-detail-pill">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16m-2-2l1.6-1.6a2 2 0 012.8 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $album->images->count() }} {{ __('frontend.gallery_photos') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="reference-gallery-section">
            <div class="reference-detail-container">
                <div class="reference-gallery-head">
                    <h2>{{ __('frontend.gallery_photos_title') }}</h2>
                    <a href="{{ route('references.index', ['locale' => current_locale()]) }}" class="reference-back-link">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('frontend.gallery_back') }}
                    </a>
                </div>

                @if ($album->images->isEmpty())
                    <div class="reference-empty">
                        <p>{{ __('frontend.gallery_no_images') }}</p>
                    </div>
                @else
                    <div class="reference-photo-grid">
                        @foreach ($album->images as $image)
                            <button type="button" class="reference-photo" @click="open({{ $loop->index }})">
                                <img src="{{ Storage::url($image->path) }}"
                                    alt="{{ $albumTitle }} - {{ $loop->iteration }}" loading="lazy">
                                <span class="reference-photo__overlay" aria-hidden="true">
                                    <span class="reference-photo__icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                        </svg>
                                    </span>
                                </span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <div x-cloak x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="reference-lightbox"
            @click.self="close()">
            <button type="button" @click="close()" class="reference-lightbox__close" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="reference-lightbox__counter">
                <span x-text="current + 1"></span> / <span x-text="total"></span>
            </div>

            <button type="button" @click.stop="prev()" x-show="total > 1"
                class="reference-lightbox__button reference-lightbox__button--prev" aria-label="Previous image">
                <svg width="21" height="21" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div class="reference-lightbox__stage">
                <img :src="images[current]" :alt="'Photo ' + (current + 1)" @click.stop>
            </div>

            <button type="button" @click.stop="next()" x-show="total > 1"
                class="reference-lightbox__button reference-lightbox__button--next" aria-label="Next image">
                <svg width="21" height="21" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            @if ($album->images->count() > 1)
                <div class="reference-thumbs">
                    @foreach ($album->images as $image)
                        <button type="button" @click.stop="open({{ $loop->index }})"
                            :class="current === {{ $loop->index }} ? 'is-active' : ''"
                            class="reference-thumb">
                            <img src="{{ Storage::url($image->path) }}" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    @push('scripts')
        <script>
            function galleryLightbox() {
                return {
                    isOpen: false,
                    current: 0,
                    images: @json($album->images->map(fn($i) => \Illuminate\Support\Facades\Storage::url($i->path))->values()),
                    total: {{ $album->images->count() }},
                    open(index) {
                        this.current = index;
                        this.isOpen = true;
                        document.body.style.overflow = 'hidden';
                    },
                    close() {
                        this.isOpen = false;
                        document.body.style.overflow = '';
                    },
                    prev() {
                        if (!this.isOpen || this.total < 1) return;
                        this.current = (this.current - 1 + this.total) % this.total;
                    },
                    next() {
                        if (!this.isOpen || this.total < 1) return;
                        this.current = (this.current + 1) % this.total;
                    },
                }
            }
        </script>
    @endpush
@endsection
