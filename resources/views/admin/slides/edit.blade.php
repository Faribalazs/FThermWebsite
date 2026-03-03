@extends('layouts.admin')

@section('title', 'Izmeni slajd')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.slides.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Nazad na slajdove
        </a>
    </div>

    <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-white">Izmeni slajd #{{ $slide->id }}</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Uredite sadržaj slajda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Slika</h2>
                <p class="text-[11px] text-gray-400 mt-0.5">Ostavite prazno da zadržite trenutnu sliku</p>
            </div>
            <div class="p-4 sm:p-6">
                <div x-data="{ preview: null }" class="space-y-3">
                    <!-- Current image -->
                    <div x-show="!preview" class="relative rounded-xl overflow-hidden h-48 bg-gray-100">
                        <img src="{{ Storage::url($slide->image) }}" alt="" class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded-lg font-medium">Trenutna slika</div>
                    </div>
                    <!-- New preview -->
                    <template x-if="preview">
                        <img :src="preview" class="rounded-xl h-48 w-full object-cover">
                    </template>
                    <label class="block cursor-pointer">
                        <div class="border-2 border-dashed border-gray-300 hover:border-primary-400 rounded-xl p-4 text-center transition-colors">
                            <p class="text-sm text-gray-500">Kliknite da zamenite sliku</p>
                        </div>
                        <input type="file" name="image" accept="image/*" class="hidden"
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
                            <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $slide->title[$lang] ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="Naslov slajda ({{ $label }})">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Opis</label>
                            <textarea name="description_{{ $lang }}" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all resize-none" placeholder="Kratki opis ({{ $label }})">{{ old('description_'.$lang, $slide->description[$lang] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Tekst dugmeta</label>
                            <input type="text" name="button_text_{{ $lang }}" value="{{ old('button_text_'.$lang, $slide->button_text[$lang] ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="npr. Saznaj više ({{ $label }})">
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
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Link dugmeta</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slide->button_link) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" placeholder="npr. /sr/shop  ili  https://...">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Pozicija teksta — horizontalno</label>
                    <select name="text_position_x" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white">
                        <option value="left"   {{ old('text_position_x', $slide->text_position_x) === 'left'   ? 'selected' : '' }}>⬅ Levo</option>
                        <option value="center" {{ old('text_position_x', $slide->text_position_x) === 'center' ? 'selected' : '' }}>↔ Centar</option>
                        <option value="right"  {{ old('text_position_x', $slide->text_position_x) === 'right'  ? 'selected' : '' }}>➡ Desno</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Pozicija teksta — vertikalno</label>
                    <select name="text_position_y" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white">
                        <option value="top"    {{ old('text_position_y', $slide->text_position_y) === 'top'    ? 'selected' : '' }}>⬆ Gore</option>
                        <option value="center" {{ old('text_position_y', $slide->text_position_y) === 'center' ? 'selected' : '' }}>↕ Centar</option>
                        <option value="bottom" {{ old('text_position_y', $slide->text_position_y) === 'bottom' ? 'selected' : '' }}>⬇ Dole</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Redosled</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order) }}" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                </div>

                <div class="sm:col-span-2 lg:col-span-3 flex items-center gap-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" {{ old('active', $slide->active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                    <span class="text-sm font-semibold text-gray-700">Aktivan</span>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-between gap-3">
            <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Obrisati slajd?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Obriši slajd
                </button>
            </form>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.slides.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 transition">Otkaži</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Sačuvaj promene
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
