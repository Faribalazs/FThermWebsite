@extends('layouts.admin')

@section('title', 'Novi album')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na galeriju
        </a>
    </div>

    <form action="{{ route('admin.gallery.store') }}" method="POST">
        @csrf

        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-white">Novi album</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Kreirajte novi galerijski album</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Translations Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="{ langTab: 'sr' }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Prevodi</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Naziv i opis albuma na svim jezicima</p>
            </div>

            <!-- Language Tabs -->
            <div class="flex border-b border-gray-200 px-4 sm:px-6">
                @foreach(['sr' => ['flag' => '🇷🇸', 'label' => 'Srpski'], 'en' => ['flag' => '🇬🇧', 'label' => 'English'], 'hu' => ['flag' => '🇭🇺', 'label' => 'Magyar']] as $code => $lang)
                <button type="button" @click="langTab = '{{ $code }}'"
                    :class="langTab === '{{ $code }}' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200">
                    <span class="text-base">{{ $lang['flag'] }}</span> {{ $lang['label'] }}
                </button>
                @endforeach
            </div>

            <div class="p-4 sm:p-6">
                @foreach(['sr' => 'Srpski', 'en' => 'English', 'hu' => 'Magyar'] as $code => $label)
                <div x-show="langTab === '{{ $code }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label for="title_{{ $code }}" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv <span class="text-red-500">*</span></label>
                            <input type="text" id="title_{{ $code }}" name="title_{{ $code }}" required
                                value="{{ old('title_' . $code) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                placeholder="Unesite naziv albuma ({{ $label }})">
                            @error('title_' . $code) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description_{{ $code }}" class="block text-sm font-bold text-gray-700 mb-1.5">Opis</label>
                            <textarea id="description_{{ $code }}" name="description_{{ $code }}" rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                                placeholder="Unesite opis albuma ({{ $label }})">{{ old('description_' . $code) }}</textarea>
                            @error('description_' . $code) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Settings Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Podešavanja</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Slug, redosled i vidljivost</p>
            </div>
            <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="slug" class="block text-sm font-bold text-gray-700 mb-1.5">Slug (URL) <span class="text-red-500">*</span></label>
                    <div class="flex items-center">
                        <span class="px-3 py-2.5 bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl text-sm text-gray-500">/galerija/</span>
                        <input type="text" id="slug" name="slug" required value="{{ old('slug') }}"
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-r-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200"
                            placeholder="naziv-albuma">
                    </div>
                    @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="order" class="block text-sm font-bold text-gray-700 mb-1.5">Redosled <span class="text-red-500">*</span></label>
                    <input type="number" id="order" name="order" required value="{{ old('order', 1) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                    @error('order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-3">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-checked:bg-primary-600 rounded-full transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-primary-500/30"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-700">Aktivan album</span>
                            <p class="text-[11px] text-gray-400">Prikazati album na sajtu</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row gap-3 justify-end">
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all duration-200">
                Otkaži
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-8 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Sačuvaj album
            </button>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title_sr
document.addEventListener('DOMContentLoaded', function () {
    const titleSr = document.getElementById('title_sr');
    const slugInput = document.getElementById('slug');
    let slugTouched = false;

    slugInput.addEventListener('input', () => { slugTouched = true; });

    titleSr.addEventListener('input', function () {
        if (slugTouched) return;
        slugInput.value = this.value
            .toLowerCase()
            .replace(/š/g, 's').replace(/đ/g, 'dj').replace(/č/g, 'c').replace(/ć/g, 'c').replace(/ž/g, 'z')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-').replace(/-+/g, '-');
    });
});
</script>
@endsection
