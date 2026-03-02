@extends('layouts.admin')

@section('title', 'Sadržaj naslove strane')

@section('content')
<div class="animate-fade-in-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Sadržaj Naslovne Strane</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Uredite tekstualni sadržaj koji se prikazuje na naslovnoj strani</p>
            </div>
        </div>
        <a href="{{ route('admin.homepage-contents.create') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl text-xs sm:text-sm font-bold text-white hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 w-full sm:w-auto">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Dodaj sekciju
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border border-green-200 rounded-xl sm:rounded-2xl flex items-center gap-3">
        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Stats -->
    <div class="mb-4 sm:mb-6 flex items-center gap-3">
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-primary-100 to-primary-200 text-primary-800 border border-primary-200">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            {{ $contents->count() }} {{ $contents->count() == 1 ? 'stavka' : 'stavki' }}
        </span>
    </div>

    <div class="space-y-3 sm:space-y-4">
        @forelse($contents as $content)
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-200 group">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 sm:gap-4">
                    <div class="flex-1 min-w-0">
                        <!-- Title & Key -->
                        <div class="flex items-center gap-2.5 mb-3">
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate">{{ ucfirst(str_replace('_', ' ', $content->key)) }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:text-xs font-mono font-medium bg-gray-100 text-gray-600 border border-gray-200">{{ $content->key }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex sm:flex-col gap-2 flex-shrink-0 w-full sm:w-auto">
                        <a href="{{ route('admin.homepage-contents.edit', $content) }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-xs sm:text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-md hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Izmeni
                        </a>
                        <form action="{{ route('admin.homepage-contents.destroy', $content) }}" method="POST" data-confirm="Da li ste sigurni da želite da obrišete ovu sekciju?" data-type="delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-br from-red-50 to-red-100 text-red-700 rounded-xl text-xs sm:text-sm font-bold hover:from-red-100 hover:to-red-200 border border-red-200 transition-all duration-200 shadow-sm hover:shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Obriši
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 sm:p-12 text-center">
            <div class="flex flex-col items-center justify-center text-gray-500">
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-4">
                    <svg class="h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-gray-900">Nema sadržaja</p>
                <p class="mt-1 text-sm text-gray-500 mb-4">Sadržaj naslovne strane još nije kreiran.</p>
                <a href="{{ route('admin.homepage-contents.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Dodaj sekciju
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
