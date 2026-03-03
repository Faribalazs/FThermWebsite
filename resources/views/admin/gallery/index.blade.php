@extends('layouts.admin')

@section('title', 'Galerija')

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
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Galerija</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upravljajte albumima i slikama</p>
            </div>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="inline-flex items-center px-4 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-xs sm:text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Novi album
        </a>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-900">{{ $albums->total() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Ukupno albuma</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-green-600">{{ $albums->where('active', true)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Aktivni</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-400">{{ $albums->where('active', false)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Neaktivni</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Albums Grid -->
    @forelse($albums as $album)
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden mb-4 hover:shadow-lg transition-all duration-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 sm:p-5">
            <!-- Thumbnail -->
            <div class="w-full sm:w-24 h-32 sm:h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 relative">
                @if($album->images->first())
                    <img src="{{ Storage::url($album->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <p class="text-sm font-bold text-gray-900">{{ $album->title['sr'] ?? $album->title['en'] ?? '' }}</p>
                    @if($album->active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktivan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-50 text-gray-500 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Neaktivan
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-400">{{ $album->images_count }} {{ $album->images_count === 1 ? 'slika' : ($album->images_count < 5 ? 'slike' : 'slika') }} &middot; Redosled: {{ $album->order }} &middot; /{{ $album->slug }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                <a href="{{ route('admin.gallery.edit', $album) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-all duration-200 hover:scale-110" title="Izmeni">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                <form action="{{ route('admin.gallery.destroy', $album) }}" method="POST" class="inline"
                      data-confirm="Da li ste sigurni da želite da obrišete album '{{ $album->title['sr'] ?? '' }}' i sve slike u njemu?"
                      data-type="delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-all duration-200 hover:scale-110" title="Obriši">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">Nema albuma</p>
        <p class="text-gray-400 text-sm mt-1">Kreirajte prvi album klikom na dugme gore.</p>
    </div>
    @endforelse

    <!-- Pagination -->
    @if($albums->hasPages())
    <div class="mt-6">
        {{ $albums->links() }}
    </div>
    @endif
</div>
@endsection
