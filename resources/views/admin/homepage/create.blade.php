@extends('layouts.admin')

@section('title', 'Nova sekcija')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.homepage-contents.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na sadržaj
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Nova Sekcija</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Kreirajte novu sekciju sadržaja za naslovnu stranu</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.homepage-contents.store') }}" method="POST">
        @csrf

        <!-- Key Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 rounded-t-2xl">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Identifikacija sekcije
                </h2>
            </div>
            <div class="p-4 sm:p-6">
                <label for="key" class="block text-sm font-semibold text-gray-700 mb-1.5">Ključ sekcije <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <input type="text" id="key" name="key" required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-mono text-sm"
                        placeholder="npr. hero_title, about_description" value="{{ old('key') }}">
                </div>
                <p class="mt-1.5 text-[10px] sm:text-xs text-gray-400">Koristite mala slova i donje crte (npr. hero_title). Ovo je jedinstveni identifikator.</p>
                @error('key') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
            <div x-show="langTab === 'sr'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6">
                <label for="value_sr" class="block text-sm font-semibold text-gray-700 mb-1.5">Sadržaj <span class="text-red-500">*</span></label>
                <textarea id="value_sr" name="value_sr" rows="8" required class="tinymce-editor" placeholder="Unesite srpski sadržaj...">{{ old('value_sr') }}</textarea>
                @error('value_sr') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- English Tab -->
            <div x-show="langTab === 'en'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6">
                <label for="value_en" class="block text-sm font-semibold text-gray-700 mb-1.5">Sadržaj <span class="text-red-500">*</span></label>
                <textarea id="value_en" name="value_en" rows="8" required class="tinymce-editor" placeholder="Enter English content...">{{ old('value_en') }}</textarea>
                @error('value_en') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Hungarian Tab -->
            <div x-show="langTab === 'hu'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-4 sm:p-6">
                <label for="value_hu" class="block text-sm font-semibold text-gray-700 mb-1.5">Sadržaj <span class="text-red-500">*</span></label>
                <textarea id="value_hu" name="value_hu" rows="8" required class="tinymce-editor" placeholder="Adja meg a magyar tartalmat...">{{ old('value_hu') }}</textarea>
                @error('value_hu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row justify-between items-stretch sm:items-center gap-3">
            <a href="{{ route('admin.homepage-contents.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all duration-200 font-bold text-sm">
                Otkaži
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition-all duration-200 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Kreiraj sekciju
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '.tinymce-editor',
        height: 350,
        menubar: false,
        plugins: 'lists link code table wordcount fullscreen',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link table | code fullscreen',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; line-height: 1.6; color: #374151; }',
        branding: false,
        promotion: false,
        skin: 'oxide',
        content_css: 'default',
        setup: function(editor) {
            editor.on('change keyup', function() {
                editor.save();
            });
        }
    });
});
</script>
@endpush
