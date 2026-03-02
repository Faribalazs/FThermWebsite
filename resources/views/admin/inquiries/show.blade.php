@extends('layouts.admin')

@section('title', 'Pregled upita')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na upite
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">{{ $inquiry->name }}</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">{{ $inquiry->created_at->format('d.m.Y') }} u {{ $inquiry->created_at->format('H:i') }}</p>
                </div>
            </div>
            @if($inquiry->is_read)
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                    Pročitano
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-secondary-500 to-secondary-600 text-white shadow-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                    Novo
                </span>
            @endif
        </div>
    </div>

    <!-- Contact Information Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6">
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Kontakt Informacije
            </h2>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Name -->
                <div class="flex items-start gap-3">
                    <div>
                        <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Ime</p>
                        <p class="text-sm sm:text-base font-semibold text-gray-900 mt-0.5">{{ $inquiry->name }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Email</p>
                        <a href="mailto:{{ $inquiry->email }}" class="text-sm sm:text-base font-semibold text-primary-600 hover:text-primary-700 hover:underline mt-0.5 block truncate">{{ $inquiry->email }}</a>
                    </div>
                </div>

                <!-- Phone -->
                @if($inquiry->phone)
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Telefon</p>
                        <a href="tel:{{ $inquiry->phone }}" class="text-sm sm:text-base font-semibold text-primary-600 hover:text-primary-700 hover:underline mt-0.5 block">{{ $inquiry->phone }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Message Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6">
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                Poruka
            </h2>
        </div>
        <div class="p-4 sm:p-6">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl p-4 sm:p-6 border border-gray-100">
                <p class="text-sm sm:text-base text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col-reverse sm:flex-row justify-between items-stretch sm:items-center gap-3">
        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" data-confirm="Da li ste sigurni da želite da obrišete ovaj upit?" data-type="delete">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 border-2 border-red-200 rounded-xl text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 transition-all duration-200 font-bold shadow-sm hover:shadow-md hover:border-red-300 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Obriši upit
            </button>
        </form>
        
        <a href="{{ route('admin.inquiries.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition-all duration-200 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na listu
        </a>
    </div>
</div>
@endsection
