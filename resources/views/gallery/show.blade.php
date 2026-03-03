@extends('layouts.public')

@section('title', translate($album->title) . ' - FTHERM')

@section('content')
<div x-data="galleryLightbox()" x-on:keydown.escape.window="close()" x-on:keydown.arrow-left.window="prev()" x-on:keydown.arrow-right.window="next()">

<!-- Page Hero -->
<section class="pt-20 pb-10 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <div class="absolute inset-0 [background-image:radial-gradient(#d1d5db_1px,transparent_1px)] [background-size:20px_20px] opacity-25 pointer-events-none"></div>
    <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('gallery.index', current_locale()) }}" class="hover:text-primary-600 transition-colors font-medium">
                {{ __('frontend.gallery_title') }}
            </a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium">{{ translate($album->title) }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-xs font-extrabold uppercase tracking-widest mb-4">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                    {{ __('frontend.gallery_badge') }}
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight mb-3">
                    {{ translate($album->title) }}
                </h1>
                @if(translate($album->description))
                <p class="text-gray-500 leading-relaxed max-w-2xl">{{ translate($album->description) }}</p>
                @endif
            </div>
            <div class="flex-shrink-0">
                <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-600 text-sm font-bold px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $album->images->count() }} {{ __('frontend.gallery_photos') }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Images Grid -->
<section class="py-12 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
        @if($album->images->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-400 text-lg">{{ __('frontend.gallery_no_images') }}</p>
            </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
            @foreach($album->images as $image)
            <button type="button"
                @click="open({{ $loop->index }})"
                class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <img src="{{ Storage::url($image->path) }}"
                     alt="{{ translate($album->title) }} - {{ $loop->iteration }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-400">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-200 flex items-center justify-center">
                    <div class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center opacity-0 group-hover:opacity-100 scale-75 group-hover:scale-100 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
                </div>
            </button>
            @endforeach
        </div>
        @endif

        <!-- Back to Gallery -->
        <div class="mt-12 text-center">
            <a href="{{ route('gallery.index', current_locale()) }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('frontend.gallery_back') }}
            </a>
        </div>
    </div>
</section>

<!-- ─── Lightbox ─── -->
<div x-show="isOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
     @click.self="close()"
     style="display:none">

    <!-- Close button -->
    <button @click="close()"
        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10 focus:outline-none focus:ring-2 focus:ring-white/50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Counter -->
    <div class="absolute top-4 left-1/2 -translate-x-1/2 bg-black/50 text-white text-sm font-medium px-3 py-1.5 rounded-full backdrop-blur-sm">
        <span x-text="current + 1"></span> / <span x-text="total"></span>
    </div>

    <!-- Prev button -->
    <button @click.stop="prev()" x-show="total > 1"
        class="absolute left-3 sm:left-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-white/50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <!-- Image -->
    <div class="max-w-5xl max-h-[85vh] mx-14 sm:mx-20 relative">
        <img :src="images[current]"
             :alt="'Photo ' + (current + 1)"
             class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl select-none"
             @click.stop>
    </div>

    <!-- Next button -->
    <button @click.stop="next()" x-show="total > 1"
        class="absolute right-3 sm:right-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-white/50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Thumbnail strip -->
    @if($album->images->count() > 1)
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-1.5 px-3 py-2 bg-black/50 backdrop-blur-sm rounded-2xl overflow-x-auto max-w-[calc(100vw-2rem)]">
        @foreach($album->images as $image)
        <button type="button"
            @click.stop="open({{ $loop->index }})"
            :class="current === {{ $loop->index }} ? 'ring-2 ring-white opacity-100' : 'opacity-50 hover:opacity-80'"
            class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg overflow-hidden flex-shrink-0 transition-all duration-150 focus:outline-none">
            <img src="{{ Storage::url($image->path) }}" alt="" class="w-full h-full object-cover">
        </button>
        @endforeach
    </div>
    @endif
</div>

</div>{{-- /x-data --}}

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
            if (!this.isOpen) return;
            this.current = (this.current - 1 + this.total) % this.total;
        },
        next() {
            if (!this.isOpen) return;
            this.current = (this.current + 1) % this.total;
        },
    }
}
</script>
@endpush
@endsection
