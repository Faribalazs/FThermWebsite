@extends('layouts.admin')

@section('title', 'Novi slajd')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.slides.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Nazad na slajdove
        </a>
    </div>

    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-white">Novi slajd</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Dodajte novi slajd na slider</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Slika <span class="text-red-500">*</span></h2>
            </div>
            <div class="p-4 sm:p-6">
                <div x-data="{ preview: null }" class="space-y-3">
                    <label class="block cursor-pointer">
                        <div class="border-2 border-dashed border-gray-300 hover:border-primary-400 rounded-xl p-6 text-center transition-colors" :class="preview ? 'border-primary-400' : ''">
                            <template x-if="!preview">
                                <div>
                                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm text-gray-500">Kliknite ili prevucite sliku ovde</p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — max 4MB</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="max-h-56 mx-auto rounded-lg object-contain">
                            </template>
                        </div>
                        <input type="file" name="image" accept="image/*" required class="hidden"
                            @change="preview = URL.createObjectURL($event.target.files[0])">
                    </label>
                </div>
                @error('image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Translations -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="{ langTab: 'sr' }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Sadržaj po jezicima</h2>
            </div>
            <!-- Tabs -->
            <div class="flex border-b border-gray-200 px-4 sm:px-6">
                <button type="button" @click="langTab = 'sr'" :class="langTab === 'sr' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all">
                    <span class="text-base">🇷🇸</span> Srpski
                </button>
                <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all">
                    <span class="text-base">🇬🇧</span> English
                </button>
                <button type="button" @click="langTab = 'hu'" :class="langTab === 'hu' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all">
                    <span class="text-base">🇭🇺</span> Magyar
                </button>
            </div>
            <div class="p-4 sm:p-6">
                @foreach(['sr' => 'Srpski', 'en' => 'English', 'hu' => 'Magyar'] as $lang => $label)
                <div x-show="langTab === '{{ $lang }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Naslov</label>
                            <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="Naslov slajda ({{ $label }})">
                            @error('title_'.$lang)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Opis</label>
                            <textarea name="description_{{ $lang }}" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all resize-none" placeholder="Kratki opis ({{ $label }})">{{ old('description_'.$lang) }}</textarea>
                            @error('description_'.$lang)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Tekst dugmeta</label>
                            <input type="text" name="button_text_{{ $lang }}" value="{{ old('button_text_'.$lang) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="npr. Saznaj više ({{ $label }})">
                            @error('button_text_'.$lang)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Podešavanja</h2>
            </div>
            <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                <!-- Button link -->
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Link dugmeta</label>
                    <input type="text" name="button_link" value="{{ old('button_link') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="npr. /sr/shop  ili  https://...">
                    @error('button_link')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Text position X -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Pozicija teksta — horizontalno</label>
                    <select name="text_position_x" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white">
                        <option value="left"   {{ old('text_position_x','left')   === 'left'   ? 'selected' : '' }}>⬅ Levo</option>
                        <option value="center" {{ old('text_position_x','left')   === 'center' ? 'selected' : '' }}>↔ Centar</option>
                        <option value="right"  {{ old('text_position_x','left')   === 'right'  ? 'selected' : '' }}>➡ Desno</option>
                    </select>
                </div>

                <!-- Text position Y -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Pozicija teksta — vertikalno</label>
                    <select name="text_position_y" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white">
                        <option value="top"    {{ old('text_position_y','center') === 'top'    ? 'selected' : '' }}>⬆ Gore</option>
                        <option value="center" {{ old('text_position_y','center') === 'center' ? 'selected' : '' }}>↕ Centar</option>
                        <option value="bottom" {{ old('text_position_y','center') === 'bottom' ? 'selected' : '' }}>⬇ Dole</option>
                    </select>
                </div>

                <!-- Order -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Redosled</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    @error('order')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Active -->
                <div class="sm:col-span-2 lg:col-span-3 flex items-center gap-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active', '1') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                    <span class="text-sm font-semibold text-gray-700">Aktivan</span>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.slides.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 transition">Otkaži</a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Sačuvaj slajd
            </button>
        </div>
    </form>
</div>
@endsection
