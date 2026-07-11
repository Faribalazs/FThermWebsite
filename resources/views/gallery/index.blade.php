@extends('layouts.public')

@section('title', __('frontend.gallery_title') . ' - FTHERM')
@section('meta_description', __('frontend.gallery_subtitle'))
@section('og_image', asset('images/ftherm/references-hero.png'))

@section('content')
    @php
        $totalPhotos = $albums->sum('images_count');
    @endphp

    <main class="references-page">
        <section class="references-hero">
            <img src="{{ asset('images/ftherm/references-hero.png') }}" alt="{{ __('frontend.gallery_title') }}"
                class="references-hero__image" width="2048" height="804" fetchpriority="high">
            <div class="references-hero__shade"></div>
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
