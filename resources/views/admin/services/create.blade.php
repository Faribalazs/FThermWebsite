@extends('layouts.admin')

@section('title', 'Nova usluga')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na usluge
        </a>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST">
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
                        <h1 class="text-lg sm:text-xl font-bold text-white">Nova usluga</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Dodajte novu uslugu na sajt</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Translations Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="{ langTab: 'sr' }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Prevodi</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Naziv i opis usluge na svim jezicima</p>
            </div>

            <!-- Language Tabs -->
            <div class="flex border-b border-gray-200 px-4 sm:px-6">
                <button type="button" @click="langTab = 'sr'" :class="langTab === 'sr' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200">
                    <span class="text-base">🇷🇸</span> Srpski
                </button>
                <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200">
                    <span class="text-base">🇬🇧</span> English
                </button>
                <button type="button" @click="langTab = 'hu'" :class="langTab === 'hu' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200">
                    <span class="text-base">🇭🇺</span> Magyar
                </button>
            </div>

            <div class="p-4 sm:p-6">
                <!-- Serbian -->
                <div x-show="langTab === 'sr'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-1" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label for="title_sr" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv <span class="text-red-500">*</span></label>
                            <input type="text" id="title_sr" name="title_sr" required value="{{ old('title_sr') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Unesite naziv usluge">
                            @error('title_sr') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description_sr" class="block text-sm font-bold text-gray-700 mb-1.5">Opis <span class="text-red-500">*</span></label>
                            <textarea id="description_sr" name="description_sr" rows="6" required class="tinymce-editor w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Unesite opis usluge">{{ old('description_sr') }}</textarea>
                            @error('description_sr') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- English -->
                <div x-show="langTab === 'en'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-1" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label for="title_en" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv <span class="text-red-500">*</span></label>
                            <input type="text" id="title_en" name="title_en" required value="{{ old('title_en') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Enter service title">
                            @error('title_en') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description_en" class="block text-sm font-bold text-gray-700 mb-1.5">Opis <span class="text-red-500">*</span></label>
                            <textarea id="description_en" name="description_en" rows="6" required class="tinymce-editor w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Enter service description">{{ old('description_en') }}</textarea>
                            @error('description_en') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Hungarian -->
                <div x-show="langTab === 'hu'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-1" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label for="title_hu" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv <span class="text-red-500">*</span></label>
                            <input type="text" id="title_hu" name="title_hu" required value="{{ old('title_hu') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Adja meg a szolgáltatás nevét">
                            @error('title_hu') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description_hu" class="block text-sm font-bold text-gray-700 mb-1.5">Opis <span class="text-red-500">*</span></label>
                            <textarea id="description_hu" name="description_hu" rows="6" required class="tinymce-editor w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="Adja meg a szolgáltatás leírását">{{ old('description_hu') }}</textarea>
                            @error('description_hu') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Podešavanja</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Redosled i vidljivost</p>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-1.5">Redosled <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <input type="number" id="order" name="order" required value="{{ old('order', 0) }}" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="0">
                        </div>
                        @error('order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Active Toggle -->
                <div class="mt-5 pt-5 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-700">Aktivna usluga</p>
                            <p class="text-xs text-gray-500 mt-0.5">Vidljiva na sajtu</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                Otkaži
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Kreiraj uslugu
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '.tinymce-editor',
        height: 350,
        menubar: false,
        plugins: 'lists link code table wordcount fullscreen',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code fullscreen',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; }',
        branding: false,
        promotion: false,
        setup: function(editor) {
            editor.on('change keyup', function() {
                editor.save();
            });
        }
    });
</script>
@endpush
