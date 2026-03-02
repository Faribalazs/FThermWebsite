@extends('layouts.admin')

@section('title', 'Izmeni proizvod')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na proizvode
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Izmeni proizvod</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">{{ $product->name['sr'] ?? $product->name['en'] ?? '' }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Category Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-4 sm:mb-6">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 rounded-t-2xl">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Osnovno
                </h2>
            </div>
            <div class="p-4 sm:p-6">
                @php
                    $categoryOptions = ['' => 'Izaberite kategoriju'];
                    foreach ($categories as $category) {
                        $categoryOptions[$category->id] = $category->name['sr'] ?? $category->name['en'] ?? '';
                    }
                    $selectedCategory = old('category_id', $product->category_id);
                    $selectedCategoryText = $selectedCategory && $selectedCategory !== '' 
                        ? ($categories->firstWhere('id', $selectedCategory)->name['sr'] ?? $categories->firstWhere('id', $selectedCategory)->name['en'] ?? 'Izaberite kategoriju')
                        : 'Izaberite kategoriju';
                @endphp
                
                <x-custom-select
                    name="category_id"
                    id="category_id"
                    :selected="$selectedCategory"
                    :selectedText="$selectedCategoryText"
                    :options="$categoryOptions"
                    label="Kategorija *"
                />
                @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Language Tabs Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6" x-data="{ langTab: 'sr' }">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        Prevodi
                    </h2>
                    <div class="flex rounded-xl bg-gray-100 p-1 gap-1">
                        <button type="button" @click="langTab = 'sr'" :class="langTab === 'sr' ? 'bg-white shadow-md text-red-700 border-red-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 border">
                            <span class="text-base leading-none">🇷🇸</span>
                            <span class="hidden sm:inline">Српски</span>
                        </button>
                        <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'bg-white shadow-md text-blue-700 border-blue-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 border">
                            <span class="text-base leading-none">🇬🇧</span>
                            <span class="hidden sm:inline">English</span>
                        </button>
                        <button type="button" @click="langTab = 'hu'" :class="langTab === 'hu' ? 'bg-white shadow-md text-green-700 border-green-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 border">
                            <span class="text-base leading-none">🇭🇺</span>
                            <span class="hidden sm:inline">Magyar</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Serbian Tab -->
            <div x-show="langTab === 'sr'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6 space-y-4">
                <div>
                    <label for="name_sr" class="block text-sm font-semibold text-gray-700 mb-1.5">Naziv *</label>
                    <input type="text" id="name_sr" name="name_sr" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('name_sr', $product->name['sr'] ?? '') }}">
                    @error('name_sr') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="description_sr" class="block text-sm font-semibold text-gray-700 mb-1.5">Opis *</label>
                    <textarea id="description_sr" name="description_sr" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('description_sr', $product->description['sr'] ?? '') }}</textarea>
                    @error('description_sr') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="technical_specs_sr" class="block text-sm font-semibold text-gray-700 mb-1.5">Tehničke specifikacije</label>
                    <textarea id="technical_specs_sr" name="technical_specs_sr" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('technical_specs_sr', $product->technical_specs['sr'] ?? '') }}</textarea>
                    @error('technical_specs_sr') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- English Tab -->
            <div x-show="langTab === 'en'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6 space-y-4">
                <div>
                    <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-1.5">Naziv *</label>
                    <input type="text" id="name_en" name="name_en" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('name_en', $product->name['en'] ?? '') }}">
                    @error('name_en') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-1.5">Opis *</label>
                    <textarea id="description_en" name="description_en" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('description_en', $product->description['en'] ?? '') }}</textarea>
                    @error('description_en') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="technical_specs_en" class="block text-sm font-semibold text-gray-700 mb-1.5">Tehničke specifikacije</label>
                    <textarea id="technical_specs_en" name="technical_specs_en" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('technical_specs_en', $product->technical_specs['en'] ?? '') }}</textarea>
                    @error('technical_specs_en') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Hungarian Tab -->
            <div x-show="langTab === 'hu'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6 space-y-4">
                <div>
                    <label for="name_hu" class="block text-sm font-semibold text-gray-700 mb-1.5">Naziv *</label>
                    <input type="text" id="name_hu" name="name_hu" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('name_hu', $product->name['hu'] ?? '') }}">
                    @error('name_hu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="description_hu" class="block text-sm font-semibold text-gray-700 mb-1.5">Opis *</label>
                    <textarea id="description_hu" name="description_hu" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('description_hu', $product->description['hu'] ?? '') }}</textarea>
                    @error('description_hu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="technical_specs_hu" class="block text-sm font-semibold text-gray-700 mb-1.5">Tehničke specifikacije</label>
                    <textarea id="technical_specs_hu" name="technical_specs_hu" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">{{ old('technical_specs_hu', $product->technical_specs['hu'] ?? '') }}</textarea>
                    @error('technical_specs_hu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Podešavanja
                </h2>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-1.5">Slug (URL) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <input type="text" id="slug" name="slug" required class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('slug', $product->slug) }}">
                        </div>
                        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">Cena (RSD)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm font-medium">RSD</span>
                            </div>
                            <input type="number" step="0.01" id="price" name="price" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('price', $product->price) }}">
                        </div>
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-1.5">Redosled *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <input type="number" id="order" name="order" required class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" value="{{ old('order', $product->order) }}">
                        </div>
                        @error('order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-end">
                        <label class="relative inline-flex items-center gap-3 cursor-pointer group p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white transition-all duration-200 w-full has-[:checked]:border-green-200 has-[:checked]:bg-green-50">
                            <input type="checkbox" id="active" name="active" class="sr-only peer" {{ old('active', $product->active) ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 flex-shrink-0"></div>
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Aktivan</span>
                                <p class="text-[10px] text-gray-400">Proizvod je vidljiv na sajtu</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row justify-between items-stretch sm:items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all duration-200 font-bold text-sm">
                Otkaži
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition-all duration-200 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Ažuriraj proizvod
            </button>
        </div>
    </form>
</div>
@endsection
