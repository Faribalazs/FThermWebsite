@extends('layouts.worker')

@section('title', 'Novi Materijal')

@section('content')
<div class="p-3 sm:p-6 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.products.index') }}" class="hover:text-primary-600 transition">Interni Materijali</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Novi Materijal</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-6">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2.5 rounded-xl backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">Dodaj Novi Materijal</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Unesite podatke o novom internom materijalu</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('worker.products.store') }}" method="POST">
            @csrf

            <div class="p-4 sm:p-8 space-y-5 sm:space-y-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="name">
                        Naziv Materijala <span class="text-red-500">*</span>
                    </label>
                    <input
                        class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-base transition-all @error('name') border-red-400 bg-red-50 @enderror"
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="npr. Bakarna cev 1/2&quot;"
                        required
                        autocomplete="off"
                    >
                    @error('name')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Unit and Price Row -->
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Unit -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="unit">
                            Jedinica Mere <span class="text-red-500">*</span>
                        </label>
                        <input
                            class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-base transition-all @error('unit') border-red-400 bg-red-50 @enderror"
                            id="unit"
                            type="text"
                            name="unit"
                            value="{{ old('unit') }}"
                            placeholder="kom, m, kg"
                            required
                            autocomplete="off"
                        >
                        @error('unit')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="price">
                            Cena <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                class="form-input w-full pl-4 pr-14 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-base transition-all @error('price') border-red-400 bg-red-50 @enderror"
                                id="price"
                                type="number"
                                step="0.01"
                                name="price"
                                value="{{ old('price') }}"
                                placeholder="0.00"
                                required
                                inputmode="decimal"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-gray-400 font-medium text-sm">RSD</span>
                            </div>
                        </div>
                        @error('price')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Low Stock Threshold -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="low_stock_threshold">
                        Prag Niskih Zaliha <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-base transition-all @error('low_stock_threshold') border-red-400 bg-red-50 @enderror"
                            id="low_stock_threshold"
                            type="number"
                            name="low_stock_threshold"
                            value="{{ old('low_stock_threshold', 10) }}"
                            placeholder="10"
                            min="0"
                            required
                            inputmode="numeric"
                        >
                    </div>
                    <p class="mt-1.5 flex items-center gap-1.5 text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Upozorenje se prikazuje kada zalihe padnu ispod ovog broja
                    </p>
                    @error('low_stock_threshold')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions — sticky on mobile -->
            <div class="sticky bottom-0 bg-white border-t border-gray-100 px-4 sm:px-8 py-4 flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="w-full sm:w-auto sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj Materijal
                </button>
                <a href="{{ route('worker.products.index') }}"
                    class="w-full sm:w-auto sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Otkaži
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
