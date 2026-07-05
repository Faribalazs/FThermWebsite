@extends('layouts.public')

@section('title', __('frontend.gallery_title') . ' - FTHERM')
@section('meta_description', __('frontend.gallery_subtitle'))

@push('head')
    <style>
        .references-page {
            --ref-navy: #071527;
            --ref-blue: #09539a;
            --ref-blue-soft: #0c93ea;
            --ref-red: #dd2131;
            --ref-ink: #0f172a;
            --ref-muted: #64748b;
            background: #ffffff;
            color: var(--ref-ink);
        }

        .references-container {
            width: min(1440px, calc(100% - 2rem));
            margin-inline: auto;
        }

        .references-hero {
            position: relative;
            isolation: isolate;
            min-height: clamp(500px, 68vh, 700px);
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(7, 21, 39, 0.98), rgba(9, 83, 154, 0.94)),
                #071527;
            color: #ffffff;
        }

        .references-hero::before {
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

        .references-hero__image {
            position: absolute;
            inset: 0;
            z-index: -2;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 1;
            filter: saturate(1.14) contrast(1.05) brightness(1.04);
        }

        .references-hero__shade {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(circle at 78% 34%, rgba(9, 83, 154, 0.1), transparent 34%),
                radial-gradient(circle at 18% 78%, rgba(221, 33, 49, 0.08), transparent 32%),
                linear-gradient(90deg, rgba(7, 21, 39, 0.72) 0%, rgba(7, 21, 39, 0.44) 38%, rgba(7, 21, 39, 0.08) 100%),
                linear-gradient(180deg, rgba(7, 21, 39, 0.02), rgba(7, 21, 39, 0.24));
        }

        .references-hero__inner {
            display: grid;
            min-height: inherit;
            align-items: center;
            padding-block: clamp(9rem, 16vw, 12rem) clamp(4rem, 8vw, 7rem);
        }

        .references-copy {
            max-width: 760px;
        }

        .references-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: #bdefff;
            font-size: 0.82rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .references-kicker::before {
            content: "";
            width: 2rem;
            height: 2px;
            background: var(--ref-red);
        }

        .references-title {
            margin-top: 1rem;
            max-width: 820px;
            font-size: clamp(2.6rem, 7vw, 5.9rem);
            font-weight: 950;
            line-height: 0.95;
            text-wrap: balance;
        }

        .references-lead {
            margin-top: 1.25rem;
            max-width: 680px;
            color: #dbeafe;
            font-size: clamp(1rem, 2vw, 1.18rem);
            line-height: 1.8;
            text-wrap: pretty;
        }

        .references-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .references-stat {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.72rem 1rem;
            color: #e0f2fe;
            font-weight: 800;
            backdrop-filter: blur(14px);
        }

        .references-stat strong {
            color: #ffffff;
            font-size: 1.2rem;
            line-height: 1;
        }

        .references-section {
            padding-block: clamp(3.5rem, 8vw, 6rem);
            background: #ffffff;
        }

        .references-section__head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: clamp(1.8rem, 4vw, 3rem);
        }

        .references-section__head h2 {
            max-width: 720px;
            font-size: clamp(2rem, 4.2vw, 3.6rem);
            font-weight: 950;
            line-height: 1.02;
            text-wrap: balance;
        }

        .references-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .reference-album {
            position: relative;
            display: flex;
            min-height: 100%;
            overflow: hidden;
            flex-direction: column;
            border: 1px solid rgba(9, 83, 154, 0.13);
            border-radius: 8px;
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            box-shadow: 0 16px 40px rgba(7, 21, 39, 0.07);
            transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
        }

        .reference-album:hover {
            transform: translateY(-4px);
            border-color: rgba(9, 83, 154, 0.28);
            box-shadow: 0 28px 70px rgba(7, 21, 39, 0.12);
        }

        .reference-album::before {
            content: "";
            position: absolute;
            inset-inline: 0;
            top: 0;
            z-index: 2;
            height: 3px;
            transform: scaleX(0);
            transform-origin: left;
            background: linear-gradient(90deg, var(--ref-blue), var(--ref-blue-soft), var(--ref-red));
            transition: transform 0.28s ease;
        }

        .reference-album:hover::before {
            transform: scaleX(1);
        }

        .reference-album__media {
            position: relative;
            aspect-ratio: 1.18;
            overflow: hidden;
            background: #eef6ff;
        }

        .reference-album__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.55s ease;
        }

        .reference-album:hover .reference-album__media img {
            transform: scale(1.055);
        }

        .reference-album__empty {
            display: grid;
            height: 100%;
            place-items: center;
            color: #93c5fd;
        }

        .reference-album__count {
            position: absolute;
            right: 0.8rem;
            bottom: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            background: rgba(7, 21, 39, 0.72);
            padding: 0.48rem 0.7rem;
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 900;
            backdrop-filter: blur(12px);
        }

        .reference-album__body {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            padding: 1.15rem;
        }

        .reference-album__number {
            color: var(--ref-blue);
            font-size: 0.72rem;
            font-weight: 950;
            text-transform: uppercase;
        }

        .reference-album__title {
            margin-top: 0.55rem;
            color: #020617;
            font-size: 1.15rem;
            font-weight: 950;
            line-height: 1.22;
            transition: color 0.2s ease;
        }

        .reference-album:hover .reference-album__title {
            color: var(--ref-blue);
        }

        .reference-album__text {
            display: -webkit-box;
            margin-top: 0.7rem;
            overflow: hidden;
            color: var(--ref-muted);
            font-size: 0.92rem;
            line-height: 1.65;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .reference-album__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: auto;
            padding-top: 1rem;
            color: var(--ref-blue);
            font-size: 0.9rem;
            font-weight: 950;
        }

        .reference-album__cta svg {
            transition: transform 0.2s ease;
        }

        .reference-album:hover .reference-album__cta svg {
            transform: translateX(3px);
        }

        .references-empty {
            display: grid;
            min-height: 280px;
            place-items: center;
            border: 1px solid rgba(9, 83, 154, 0.12);
            border-radius: 8px;
            background: #f8fbff;
            text-align: center;
        }

        .references-empty svg {
            margin-inline: auto;
            color: #93c5fd;
        }

        .references-empty p {
            margin-top: 1rem;
            color: var(--ref-muted);
            font-weight: 800;
        }

        @media (max-width: 1024px) {
            .references-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .references-container {
                width: min(1440px, calc(100% - 32px));
            }

            .references-hero {
                min-height: 560px;
            }

            .references-section__head {
                display: block;
            }

            .references-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $featuredAlbum = $albums->first();
        $featuredImage = $featuredAlbum?->images->first();
        $totalPhotos = $albums->sum('images_count');
    @endphp

    <main class="references-page">
        <section class="references-hero">
            @if ($featuredImage)
                <img src="{{ Storage::url($featuredImage->path) }}" alt="{{ translate($featuredAlbum->title) }}"
                    class="references-hero__image">
                <div class="references-hero__shade"></div>
            @endif
            <div class="references-container references-hero__inner">
                <div class="references-copy">
                    <p class="references-kicker">{{ __('frontend.gallery_badge') }}</p>
                    <h1 class="references-title">{{ __('frontend.gallery_title') }}</h1>
                    <p class="references-lead">{{ __('frontend.gallery_subtitle') }}</p>
                    <div class="references-stats" aria-label="{{ __('frontend.gallery_title') }}">
                        <span class="references-stat">
                            <strong>{{ $albums->count() }}</strong>
                            <span>{{ __('frontend.gallery_projects') }}</span>
                        </span>
                        <span class="references-stat">
                            <strong>{{ $totalPhotos }}</strong>
                            <span>{{ __('frontend.gallery_photos') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="references-section">
            <div class="references-container">
                <div class="references-section__head">
                    <h2>{{ __('ftherm.gallery.title') }}</h2>
                </div>

                @if ($albums->isEmpty())
                    <div class="references-empty">
                        <div>
                            <svg width="52" height="52" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16m-2-2l1.6-1.6a2 2 0 012.8 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p>{{ __('frontend.gallery_empty') }}</p>
                        </div>
                    </div>
                @else
                    <div class="references-grid">
                        @foreach ($albums as $album)
                            @php
                                $cover = $album->images->first();
                                $title = translate($album->title);
                                $description = translate($album->description);
                            @endphp
                            <a href="{{ route('references.show', ['locale' => current_locale(), 'slug' => $album->slug]) }}"
                                class="reference-album">
                                <div class="reference-album__media">
                                    @if ($cover)
                                        <img src="{{ Storage::url($cover->path) }}" alt="{{ $title }}" loading="lazy">
                                    @else
                                        <div class="reference-album__empty">
                                            <svg width="48" height="48" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16m-2-2l1.6-1.6a2 2 0 012.8 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="reference-album__count">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16m-2-2l1.6-1.6a2 2 0 012.8 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $album->images_count }}
                                    </span>
                                </div>
                                <div class="reference-album__body">
                                    <span class="reference-album__number">{{ __('frontend.gallery_reference_label') }}
                                        {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="reference-album__title">{{ $title }}</h3>
                                    @if ($description)
                                        <p class="reference-album__text">{{ $description }}</p>
                                    @endif
                                    <span class="reference-album__cta">
                                        {{ __('frontend.gallery_view_album') }}
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
