@extends('layouts.admin')

@section('title', 'Slajdovi')

@section('content')
<div class="animate-fade-in-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-3 sm:gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Slajdovi</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upravljajte slajderima na početnoj strani</p>
            </div>
        </div>
        <a href="{{ route('admin.slides.create') }}" class="inline-flex items-center px-4 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-xs sm:text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Dodaj slajd
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-900">{{ $slides->total() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Ukupno</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-green-600">{{ $slides->where('active', true)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Aktivni</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-400">{{ $slides->where('active', false)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Neaktivni</p>
        </div>
    </div>

    <!-- Slides Grid -->
    @forelse($slides as $slide)
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden mb-4 flex flex-col sm:flex-row">
        <!-- Thumbnail -->
        <div class="sm:w-48 lg:w-64 h-36 sm:h-auto flex-shrink-0 relative overflow-hidden bg-gray-100">
            <img src="{{ Storage::url($slide->image) }}" alt="{{ translate($slide->title) }}" class="w-full h-full object-cover">
            @if(!$slide->active)
            <div class="absolute inset-0 bg-gray-900/50 flex items-center justify-center">
                <span class="text-white text-xs font-bold bg-gray-700 px-2 py-1 rounded-full">Neaktivan</span>
            </div>
            @endif
        </div>
        <!-- Info -->
        <div class="flex-1 p-4 sm:p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">{{ translate($slide->title) ?: '(bez naslova)' }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5 line-clamp-2">{{ strip_tags(translate($slide->description)) ?: '—' }}</p>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-700 font-bold text-sm flex-shrink-0">{{ $slide->order }}</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16"/></svg>
                        H: {{ $slide->text_position_x }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16"/></svg>
                        V: {{ $slide->text_position_y }}
                    </span>
                    @if(translate($slide->button_text))
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-secondary-50 text-secondary-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        {{ translate($slide->button_text) }}
                    </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $slide->active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $slide->active ? 'Aktivan' : 'Neaktivan' }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-3">
                <a href="{{ route('admin.slides.edit', $slide) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-primary-50 text-primary-700 hover:bg-primary-100 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Izmeni
                </a>
                <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Obrisati slajd?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Obriši
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 font-medium mb-4">Nema slajdova</p>
        <a href="{{ route('admin.slides.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Dodaj prvi slajd
        </a>
    </div>
    @endforelse

    {{ $slides->links() }}
</div>
@endsection
