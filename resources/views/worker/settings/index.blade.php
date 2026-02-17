@extends('layouts.worker')

@section('title', 'Podešavanja')

@section('content')
<div class="p-3 sm:p-6 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.dashboard') }}" class="hover:text-primary-600 transition">Kontrolna tabla</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Podešavanja</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">Podešavanja</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Podesite osnovne parametre sistema</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="m-3 sm:m-6 bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 font-medium text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
        @endif

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

        <!-- Settings Form -->
        <form action="{{ route('worker.settings.update') }}" method="POST" class="p-3 sm:p-8">
            @csrf

            <!-- KM Price Setting -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6 mb-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Cena Po Kilometru</h3>
                        <p class="text-sm text-gray-600">Podesite cenu po kilometru koja će se koristiti za obračun putnih troškova na fakturama</p>
                    </div>
                </div>

                <div class="max-w-md">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="km_price">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cena (RSD)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            name="km_price" 
                            id="km_price" 
                            value="{{ old('km_price', $kmPrice) }}"
                            class="form-input w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('km_price') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. 50"
                            step="0.01"
                            min="0"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 text-sm font-medium">RSD/km</span>
                        </div>
                    </div>
                    @error('km_price')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Ova cena će biti korišćena za obračun putnih troškova
                    </p>
                </div>
            </div>

            <!-- Company Data Settings -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-4 sm:p-6 mb-6">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-green-500 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Podaci o Kompaniji</h3>
                        <p class="text-sm text-gray-600">Unesite osnovne podatke o vašoj kompaniji koji će se prikazivati na fakturama</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Company Name -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_name">
                            Naziv Kompanije
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_name" 
                            id="company_name" 
                            value="{{ old('company_name', $companyName) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_name') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. F-Therm d.o.o."
                            required
                        >
                        @error('company_name')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- PIB -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_pib">
                            PIB
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_pib" 
                            id="company_pib" 
                            value="{{ old('company_pib', $companyPib) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_pib') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. 123456789"
                            required
                        >
                        @error('company_pib')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Maticni Broj -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_maticni_broj">
                            Matični Broj
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_maticni_broj" 
                            id="company_maticni_broj" 
                            value="{{ old('company_maticni_broj', $companyMaticniBroj) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_maticni_broj') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. 987654321"
                            required
                        >
                        @error('company_maticni_broj')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Sifra Delatnosti -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_sifra_delatnosti">
                            Šifra Delatnosti
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_sifra_delatnosti" 
                            id="company_sifra_delatnosti" 
                            value="{{ old('company_sifra_delatnosti', $companySifraDelatnosti) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_sifra_delatnosti') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. 51540"
                            required
                        >
                        @error('company_sifra_delatnosti')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_phone">
                            Telefon
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_phone" 
                            id="company_phone" 
                            value="{{ old('company_phone', $companyPhone) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_phone') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. +381 11 123 4567"
                            required
                        >
                        @error('company_phone')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_email">
                            Email
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="company_email" 
                            id="company_email" 
                            value="{{ old('company_email', $companyEmail) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_email') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. info@ftherm.rs"
                            required
                        >
                        @error('company_email')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_address">
                            Adresa
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_address" 
                            id="company_address" 
                            value="{{ old('company_address', $companyAddress) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_address') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. Industrijska 15, 11000 Beograd"
                            required
                        >
                        @error('company_address')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Bank Account -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="company_bank_account">
                            Tekući Račun
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_bank_account" 
                            id="company_bank_account" 
                            value="{{ old('company_bank_account', $companyBankAccount) }}"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('company_bank_account') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="Npr. 265-1100310005641-04 Raiffeisenbank"
                            required
                        >
                        @error('company_bank_account')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('worker.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Otkaži
                </a>
                <button type="submit" class="btn-gradient inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj Podešavanja
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
