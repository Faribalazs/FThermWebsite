@extends('layouts.worker')

@section('title', 'Uredi Radni Nalog')

@section('content')
<div class="p-3 sm:p-6 max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Uredi Radni Nalog</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">Uredi Radni Nalog</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Ažurirajte podatke o radnom nalogu i uslugama</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="m-3 sm:m-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-medium text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Body -->
        <form action="{{ route('worker.work-orders.update', $workOrder) }}" method="POST" class="p-3 sm:p-8" id="workOrderForm">
            @csrf
            @method('PUT')
            
            <!-- Client Type Selection -->
            <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Tip Klijenta
                    <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-primary-400 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50 has-[:checked]:shadow-lg">
                        <input 
                            type="radio" 
                            name="client_type" 
                            value="fizicko_lice" 
                            class="sr-only peer"
                            onchange="toggleClientFields()"
                            {{ old('client_type', $workOrder->client_type) == 'fizicko_lice' ? 'checked' : '' }}
                        >
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">Fizičko Lice</span>
                        </div>
                    </label>
                    <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-primary-400 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50 has-[:checked]:shadow-lg">
                        <input 
                            type="radio" 
                            name="client_type" 
                            value="pravno_lice" 
                            class="sr-only peer"
                            onchange="toggleClientFields()"
                            {{ old('client_type', $workOrder->client_type) == 'pravno_lice' ? 'checked' : '' }}
                        >
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">Pravno Lice</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Client Info -->
            <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- For Fizicko Lice -->
                <div id="fizicko_lice_fields">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="client_name">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Ime i Prezime
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="client_name" 
                                id="client_name" 
                                value="{{ old('client_name', $workOrder->client_name) }}"
                                class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('client_name') border-red-500 ring-2 ring-red-200 error @enderror"
                                placeholder="Unesite ime i prezime"
                            >
                            @error('client_name')
                                <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="client_address">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Adresa
                            </label>
                            <input 
                                type="text" 
                                name="client_address" 
                                id="client_address" 
                                value="{{ old('client_address', $workOrder->client_address) }}"
                                class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('client_address') border-red-500 ring-2 ring-red-200 error @enderror"
                                placeholder="Unesite adresu"
                            >
                            @error('client_address')
                                <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- For Pravno Lice -->
                <div id="pravno_lice_fields" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_name">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Naziv Kompanije
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="company_name" 
                                id="company_name" 
                                value="{{ old('company_name', $workOrder->company_name) }}"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                placeholder="Unesite naziv kompanije"
                            >
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="pib">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                PIB
                            </label>
                            <input 
                                type="text" 
                                name="pib" 
                                id="pib" 
                                value="{{ old('pib', $workOrder->pib) }}"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                placeholder="Unesite PIB"
                            >
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="maticni_broj">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Matični Broj
                            </label>
                            <input 
                                type="text" 
                                name="maticni_broj" 
                                id="maticni_broj" 
                                value="{{ old('maticni_broj', $workOrder->maticni_broj) }}"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                placeholder="Unesite matični broj"
                            >
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_address">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Adresa
                            </label>
                            <input 
                                type="text" 
                                name="company_address" 
                                id="company_address" 
                                value="{{ old('company_address', $workOrder->company_address) }}"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                placeholder="Unesite adresu kompanije"
                            >
                        </div>
                    </div>
                </div>

                <!-- Common Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="client_phone">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telefon
                        </label>
                        <input 
                            type="text" 
                            name="client_phone" 
                            id="client_phone" 
                            value="{{ old('client_phone', $workOrder->client_phone) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Broj telefona"
                        >
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="client_email">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email
                        </label>
                        <input 
                            type="email" 
                            name="client_email" 
                            id="client_email" 
                            value="{{ old('client_email', $workOrder->client_email) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Email adresa"
                        >
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="location">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Mesto
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        value="{{ old('location', $workOrder->location) }}"
                        class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('location') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="Unesite lokaciju"
                        required
                    >
                    @error('location')
                        <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="km_to_destination">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Kilometara do destinacije
                    </label>
                    <input 
                        type="number" 
                        name="km_to_destination" 
                        id="km_to_destination" 
                        value="{{ old('km_to_destination', $workOrder->km_to_destination) }}"
                        class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('km_to_destination') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="npr. 25"
                        step="0.01"
                        min="0"
                    >
                    @error('km_to_destination')
                        <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opciono - Kilometraža će biti korišćena za fakturisanje</p>
                </div>
            </div>

            <!-- Sections -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Usluge</h2>
                    <button type="button" onclick="addSection()" class="btn-gradient inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Dodaj Uslugu
                    </button>
                </div>

                <div id="sectionsContainer" class="space-y-6">
                    <!-- Sections will be added here dynamically -->
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('worker.work-orders.show', $workOrder) }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Otkaži
                </a>
                <button type="submit" class="btn-gradient inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Ažuriraj Radni Nalog
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let sectionIndex = 0;
const products = @json($products);
const existingSections = @json($workOrder->sections);

// Initialize on page load with existing sections
document.addEventListener('DOMContentLoaded', function() {
    toggleClientFields();
    
    // Populate existing sections
    if (existingSections && existingSections.length > 0) {
        existingSections.forEach(section => {
            const newSectionIndex = addSection();
            
            // Set section title
            const titleInput = document.querySelector(`[data-section="${newSectionIndex}"] input[name="sections[${newSectionIndex}][title]"]`);
            if (titleInput) {
                titleInput.value = section.title || '';
            }
            
            // Set hours spent
            const hoursInput = document.querySelector(`[data-section="${newSectionIndex}"] input[name="sections[${newSectionIndex}][hours_spent]"]`);
            if (hoursInput && section.hours_spent) {
                hoursInput.value = section.hours_spent;
            }
            
            // Set service price
            const priceInput = document.querySelector(`[data-section="${newSectionIndex}"] input[name="sections[${newSectionIndex}][service_price]"]`);
            if (priceInput && section.service_price) {
                priceInput.value = section.service_price;
            }
            
            // Clear the automatically added first item
            const itemsContainer = document.getElementById(`itemsContainer_${newSectionIndex}`);
            if (itemsContainer) {
                itemsContainer.innerHTML = '';
            }
            
            // Add existing items
            if (section.items && section.items.length > 0) {
                section.items.forEach(item => {
                    const newItemId = addItem(newSectionIndex);
                    
                    // Set product
                    const product = products.find(p => p.id === item.product_id);
                    if (product) {
                        const stock = product.inventory ? product.inventory.quantity : 0;
                        const productName = product.name.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                        const productUnit = product.unit.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                        const displayText = `${productName} - ${product.price} RSD/${productUnit}`;
                        
                        setTimeout(() => {
                            selectProduct(newSectionIndex, newItemId, product.id, displayText, product.price, stock);
                            
                            // Set quantity
                            const quantityInput = document.querySelector(`[data-section="${newSectionIndex}"] [data-item="${newItemId}"] input[type="number"]`);
                            if (quantityInput && item.quantity) {
                                quantityInput.value = item.quantity;
                                validateStock(newSectionIndex, newItemId);
                                updateItemPrice(newSectionIndex, newItemId);
                            }
                        }, 50);
                    }
                });
            }
        });
    } else {
        // If no existing sections, add one empty section
        addSection();
    }
});

function addSection() {
    sectionIndex++;
    const container = document.getElementById('sectionsContainer');
    
    const sectionHtml = `
        <div class="section-block bg-gray-50 border-2 border-gray-200 rounded-xl p-6 animate-scale-in" data-section="${sectionIndex}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Usluga ${sectionIndex}
                </h3>
                <button type="button" onclick="removeSection(${sectionIndex})" class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Naziv Usluge *</label>
                <input 
                    type="text" 
                    name="sections[${sectionIndex}][title]" 
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="npr. Montaža, Materijal, itd."
                    required
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Utrošeno radni sati (sati)
                    </label>
                    <input 
                        type="number" 
                        name="sections[${sectionIndex}][hours_spent]" 
                        class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="npr. 2.5"
                        step="0.25"
                        min="0"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opciono - Koliko sati je utrošeno</p>
                </div>
                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cena usluge (RSD)
                    </label>
                    <input 
                        type="number" 
                        name="sections[${sectionIndex}][service_price]" 
                        class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="npr. 5000"
                        step="0.01"
                        min="0"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opciono - Cena ove usluge</p>
                </div>
            </div>

            <div class="space-y-3" id="itemsContainer_${sectionIndex}">
                <!-- Items will be added here -->
            </div>

            <button type="button" onclick="addItem(${sectionIndex})" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Dodaj Stavku
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
    return sectionIndex; // Return the section index for populating existing data
}

function removeSection(sectionId) {
    const section = document.querySelector(`[data-section="${sectionId}"]`);
    if (section) {
        section.remove();
    }
}

let itemCounters = {};

function addItem(sectionId) {
    if (!itemCounters[sectionId]) {
        itemCounters[sectionId] = 0;
    }
    itemCounters[sectionId]++;
    
    const itemId = itemCounters[sectionId];
    const container = document.getElementById(`itemsContainer_${sectionId}`);
    
    const itemHtml = `
        <div class="item-row bg-white border border-gray-300 rounded-lg p-4 flex gap-4 items-start" data-item="${itemId}">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-700 mb-1">Materijal *</label>
                <div class="custom-select-wrapper" id="selectWrapper_${sectionId}_${itemId}">
                    <input type="hidden" 
                        name="sections[${sectionId}][items][${itemId}][product_id]" 
                        id="productInput_${sectionId}_${itemId}"
                        required>
                    <div class="custom-select-trigger" onclick="toggleDropdown(${sectionId}, ${itemId})">
                        <span class="custom-select-value" id="selectValue_${sectionId}_${itemId}">Izaberite materijal</span>
                        <svg class="custom-select-arrow w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="custom-select-dropdown" id="dropdown_${sectionId}_${itemId}">
                        <div class="custom-select-search">
                            <svg class="search-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" 
                                class="custom-select-search-input" 
                                id="searchInput_${sectionId}_${itemId}"
                                placeholder="Pretraži materijale..."
                                oninput="filterProducts(${sectionId}, ${itemId})">
                        </div>
                        <div class="custom-select-options" id="options_${sectionId}_${itemId}">
                            ${products.map(product => {
                                const stock = product.inventory ? product.inventory.quantity : 0;
                                const stockClass = stock === 0 ? 'text-red-600' : (stock < 10 ? 'text-yellow-600' : 'text-green-600');
                                const stockBg = stock === 0 ? 'bg-red-100' : (stock < 10 ? 'bg-yellow-100' : 'bg-green-100');
                                const productName = product.name.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                                const productUnit = product.unit.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                                const displayText = `${productName} - ${product.price} RSD/${productUnit}`;
                                return `
                                <div class="custom-select-option" 
                                    data-value="${product.id}" 
                                    data-price="${product.price}"
                                    data-stock="${stock}"
                                    data-text="${displayText}"
                                    data-search="${product.name.toLowerCase()}"
                                    data-product-name="${productName}"
                                    data-product-unit="${productUnit}"
                                    onclick="selectProduct(${sectionId}, ${itemId}, ${product.id}, this.getAttribute('data-text'), ${product.price}, ${stock})">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">${productName}</div>
                                            <div class="text-xs text-gray-500">${product.price} RSD/${productUnit}</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-semibold ${stockBg} ${stockClass}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                ${stock}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `}).join('')}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-32">
                <label class="block text-xs font-medium text-gray-700 mb-1">Količina *</label>
                <input 
                    type="number" 
                    name="sections[${sectionId}][items][${itemId}][quantity]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                    min="1"
                    value="1"
                    required
                    oninput="validateStock(${sectionId}, ${itemId}); updateItemPrice(${sectionId}, ${itemId})"
                    onchange="updateItemPrice(${sectionId}, ${itemId})"
                >
            </div>
            <div class="w-32">
                <label class="block text-xs font-medium text-gray-700 mb-1">Cena</label>
                <div class="text-sm font-bold text-gray-900 px-3 py-2 bg-gray-50 rounded-lg" id="itemPrice_${sectionId}_${itemId}">
                    0.00 RSD
                </div>
            </div>
            <div class="pt-6">
                <button type="button" onclick="removeItem(${sectionId}, ${itemId})" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
    return itemId; // Return the item ID for populating existing data
}

function removeItem(sectionId, itemId) {
    const item = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"]`);
    if (item) {
        item.remove();
    }
}

function updateItemPrice(sectionId, itemId) {
    const hiddenInput = document.getElementById(`productInput_${sectionId}_${itemId}`);
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    const priceDisplay = document.getElementById(`itemPrice_${sectionId}_${itemId}`);
    
    if (hiddenInput && quantityInput && priceDisplay) {
        const productId = hiddenInput.value;
        const selectedOption = document.querySelector(`#options_${sectionId}_${itemId} [data-value="${productId}"]`);
        const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) || 0 : 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        
        priceDisplay.textContent = total.toFixed(2) + ' RSD';
    }
}

// Custom dropdown functions
function toggleDropdown(sectionId, itemId) {
    const dropdown = document.getElementById(`dropdown_${sectionId}_${itemId}`);
    const allDropdowns = document.querySelectorAll('.custom-select-dropdown');
    
    // Close all other dropdowns
    allDropdowns.forEach(dd => {
        if (dd.id !== `dropdown_${sectionId}_${itemId}`) {
            dd.classList.remove('active');
        }
    });
    
    dropdown.classList.toggle('active');
    
    // Focus search input when opening
    if (dropdown.classList.contains('active')) {
        setTimeout(() => {
            document.getElementById(`searchInput_${sectionId}_${itemId}`).focus();
        }, 100);
    }
}

function selectProduct(sectionId, itemId, productId, productText, price, stock) {
    const hiddenInput = document.getElementById(`productInput_${sectionId}_${itemId}`);
    const valueDisplay = document.getElementById(`selectValue_${sectionId}_${itemId}`);
    const dropdown = document.getElementById(`dropdown_${sectionId}_${itemId}`);
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    
    hiddenInput.value = productId;
    valueDisplay.textContent = productText;
    valueDisplay.classList.add('selected');
    dropdown.classList.remove('active');
    
    // Store stock level as data attribute on quantity input
    if (quantityInput) {
        quantityInput.setAttribute('data-stock', stock);
        quantityInput.setAttribute('max', stock > 0 ? stock : 999999);
        
        // Add validation message container if it doesn't exist
        if (!quantityInput.parentElement.querySelector('.stock-warning')) {
            const warning = document.createElement('div');
            warning.className = 'stock-warning text-xs mt-1 hidden';
            quantityInput.parentElement.appendChild(warning);
        }
    }
    
    // Update price
    updateItemPrice(sectionId, itemId);
}

function validateStock(sectionId, itemId) {
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    
    if (!quantityInput) return;
    
    const stock = parseInt(quantityInput.getAttribute('data-stock')) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    let warning = quantityInput.parentElement.querySelector('.stock-warning');
    
    if (!warning) {
        warning = document.createElement('div');
        warning.className = 'stock-warning text-xs mt-1';
        quantityInput.parentElement.appendChild(warning);
    }
    
    if (quantity > stock) {
        warning.className = 'stock-warning text-xs mt-1 text-red-600 font-medium flex items-center gap-1';
        warning.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Nedovoljno zaliha! (Dostupno: ${stock})
        `;
        quantityInput.classList.add('border-red-500');
    } else if (quantity === stock && stock > 0) {
        warning.className = 'stock-warning text-xs mt-1 text-yellow-600 font-medium flex items-center gap-1';
        warning.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Koristi svu dostupnu zalihu
        `;
        quantityInput.classList.remove('border-red-500');
    } else {
        warning.className = 'stock-warning text-xs mt-1 hidden';
        warning.innerHTML = '';
        quantityInput.classList.remove('border-red-500');
    }
}

function filterProducts(sectionId, itemId) {
    const searchInput = document.getElementById(`searchInput_${sectionId}_${itemId}`);
    const searchTerm = searchInput.value.toLowerCase();
    const options = document.querySelectorAll(`#options_${sectionId}_${itemId} .custom-select-option`);
    
    options.forEach(option => {
        const searchText = option.getAttribute('data-search');
        if (searchText.includes(searchTerm)) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select-wrapper')) {
        document.querySelectorAll('.custom-select-dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
});

// Form validation before submit
document.getElementById('workOrderForm').addEventListener('submit', function(event) {
    const quantityInputs = document.querySelectorAll('input[type="number"][name*="quantity"]');
    let hasStockError = false;
    let errorMessage = '';
    
    quantityInputs.forEach(input => {
        const stock = parseInt(input.getAttribute('data-stock'));
        const quantity = parseInt(input.value) || 0;
        
        if (!isNaN(stock) && quantity > stock) {
            hasStockError = true;
            const itemRow = input.closest('.item-row');
            const productName = itemRow ? itemRow.querySelector('.custom-select-value').textContent : 'Materijal';
            errorMessage += `${productName}: Traženo ${quantity}, dostupno ${stock}\n`;
        }
    });
    
    if (hasStockError) {
        event.preventDefault();
        alert('Nedovoljno zaliha za sledeće materijale:\n\n' + errorMessage + '\nMolimo prilagodite količine.');
        return false;
    }
});

// Toggle client type fields
function toggleClientFields() {
    const clientType = document.querySelector('input[name="client_type"]:checked').value;
    const fizickoFields = document.getElementById('fizicko_lice_fields');
    const pravnoFields = document.getElementById('pravno_lice_fields');
    const clientNameInput = document.getElementById('client_name');
    const companyNameInput = document.getElementById('company_name');
    
    if (clientType === 'fizicko_lice') {
        fizickoFields.style.display = 'block';
        pravnoFields.style.display = 'none';
        clientNameInput.required = true;
        companyNameInput.required = false;
    } else {
        fizickoFields.style.display = 'none';
        pravnoFields.style.display = 'block';
        clientNameInput.required = false;
        companyNameInput.required = true;
    }
}

</script>
@endsection
