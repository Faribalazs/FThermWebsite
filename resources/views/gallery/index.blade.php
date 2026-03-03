@extends('layouts.public')

@section('title', __('frontend.gallery_title') . ' - FTHERM')

@section('content')
<!-- Page Hero -->
<section class="pt-20 pb-12 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <div class="absolute inset-0 [background-image:radial-gradient(#d1d5db_1px,transparent_1px)] [background-size:20px_20px] opacity-25 pointer-events-none"></div>
    <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10 text-center">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-xs font-extrabold uppercase tracking-widest mb-6">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
            {{ __('frontend.gallery_badge') }}
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4 leading-tight">
            {{ __('frontend.gallery_title') }}
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            {{ __('frontend.gallery_subtitle') }}
        </p>
    </div>
</section>

<!-- Albums Grid -->
<section class="py-16 bg-white">
    <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
        @if($albums->isEmpty())
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold text-lg">{{ __('frontend.gallery_empty') }}</p>
            </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($albums as $album)
            <a href="{{ route('gallery.show', ['locale' => current_locale(), 'slug' => $album->slug]) }}"
               class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary-900/8 hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 hover:border-primary-200/70 flex flex-col">

                <!-- Cover Image -->
                <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                    @if($album->images->first())
                        <img src="{{ Storage::url($album->images->first()->path) }}"
                             alt="{{ translate($album->title) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-50">
                            <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <!-- Image count badge -->
                    <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $album->images_count }}
                    </div>
                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <span class="text-white text-sm font-bold flex items-center gap-2">
                            {{ __('frontend.gallery_view_album') }}
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Card body -->
                <div class="p-5 flex flex-col flex-1">
                    <!-- Top accent line -->
                    <div class="absolute top-0 inset-x-0 h-0.5 bg-gradient-to-r from-primary-500 to-primary-400 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-700 transition-colors leading-snug mb-1.5">
                        {{ translate($album->title) }}
                    </h3>
                    @if(translate($album->description))
                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1">
                        {{ translate($album->description) }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
