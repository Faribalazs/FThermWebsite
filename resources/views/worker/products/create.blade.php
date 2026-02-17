@extends('layouts.worker')

@section('title', 'Novi Materijal')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('worker.products.index') }}" class="hover:text-primary-600 transition">Interni Materijali</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Novi Materijal</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Dodaj Novi Materijal</h1>
                    <p class="text-primary-100 text-sm mt-1">Unesite podatke o novom internom materijalu</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('worker.products.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Product Name -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="name">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Naziv Materijala
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('name') border-red-500 ring-2 ring-red-200 error @enderror" 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="npr. Bakarna cev 1/2&quot;"
                        required
                    >
                    @error('name')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Unit and Price Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Unit -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="unit">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                            Jedinica Mere
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('unit') border-red-500 ring-2 ring-red-200 error @enderror" 
                            id="unit" 
                            type="text" 
                            name="unit" 
                            value="{{ old('unit') }}" 
                            placeholder="npr. kom, m, kg"
                            required
                        >
                        @error('unit')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="price">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Cena (RSD)
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                class="form-input w-full pl-4 pr-16 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('price') border-red-500 ring-2 ring-red-200 error @enderror" 
                                id="price" 
                                type="number" 
                                step="0.01" 
                                name="price" 
                                value="{{ old('price') }}" 
                                placeholder="0.00"
                                required
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-gray-500 font-medium">RSD</span>
                            </div>
                        </div>
                        @error('price')
                            <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Low Stock Threshold -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="low_stock_threshold">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Prag Niskih Zaliha
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('low_stock_threshold') border-red-500 ring-2 ring-red-200 error @enderror" 
                        id="low_stock_threshold" 
                        type="number" 
                        name="low_stock_threshold" 
                        value="{{ old('low_stock_threshold', 10) }}" 
                        placeholder="10"
                        min="0"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">Upozorenje se prikazuje kada zalihe padnu ispod ovog broja</p>
                    @error('low_stock_threshold')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('worker.products.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Otkaži
                </a>
                <button type="submit" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj Materijal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
