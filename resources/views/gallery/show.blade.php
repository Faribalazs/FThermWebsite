@extends('layouts.public')

@section('title', translate($album->title) . ' - FTHERM')
@section('meta_description', translate($album->description) ?: __('frontend.gallery_subtitle'))

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
