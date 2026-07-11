@extends('layouts.admin')

@section('title', 'O nama')

@php
    $languages = [
        'sr' => ['label' => 'Srpski', 'flag' => '🇷🇸'],
        'en' => ['label' => 'English', 'flag' => '🇬🇧'],
        'hu' => ['label' => 'Magyar', 'flag' => '🇭🇺'],
    ];

    $topValue = fn (string $field, string $locale) => old($field . '_' . $locale, $aboutPage->{$field}[$locale] ?? '');
    $valueField = fn (int $index, string $field, string $locale) => old("values.{$index}.{$field}_{$locale}", $aboutPage->values[$index][$field][$locale] ?? '');
    $statValue = fn (int $index) => old("stats.{$index}.value", $aboutPage->stats[$index]['value'] ?? '');
    $statLabel = fn (int $index, string $locale) => old("stats.{$index}.label_{$locale}", $aboutPage->stats[$index]['label'][$locale] ?? '');
    $heroPreview = $aboutPage->hero_image ? (str_starts_with($aboutPage->hero_image, 'images/') ? asset($aboutPage->hero_image) : Storage::url($aboutPage->hero_image)) : null;
    $secondaryPreview = $aboutPage->secondary_image ? (str_starts_with($aboutPage->secondary_image, 'images/') ? asset($aboutPage->secondary_image) : Storage::url($aboutPage->secondary_image)) : null;
@endphp

@section('content')
<div class="animate-fade-in-up">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 shadow-lg">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
            <div>
                <h1 class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-2xl font-bold text-transparent lg:text-3xl">O nama stranica</h1>
                <p class="mt-0.5 text-sm text-gray-500">Uredite tekst, slike, statistike i vrednosti za javnu O nama stranicu</p>
            </div>
        </div>
        <a href="{{ route('about', ['locale' => 'sr']) }}" target="_blank" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">
            Pogledaj stranicu
        </a>
    </div>

    <form action="{{ route('admin.about-page.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="w-full space-y-6">
            <div class="space-y-6">
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg" x-data="{ langTab: 'sr' }">
                    <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-4 sm:px-6">
                        <h2 class="font-bold text-gray-900">Glavni sadržaj</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Naslovi, uvod i tekst stranice na svim jezicima</p>
                    </div>

                    <div class="flex overflow-x-auto border-b border-gray-200 px-4 sm:px-6">
                        @foreach ($languages as $locale => $language)
                            <button type="button" @click="langTab = '{{ $locale }}'" :class="langTab === '{{ $locale }}' ? 'border-primary-500 bg-primary-50/50 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-3 text-sm font-bold transition">
                                <span>{{ $language['flag'] }}</span> {{ $language['label'] }}
                            </button>
                        @endforeach
                    </div>

                    <div class="p-4 sm:p-6">
                        @foreach ($languages as $locale => $language)
                            <div x-show="langTab === '{{ $locale }}'" x-transition>
                                <div class="space-y-5">
                                    <div>
                                        <label for="eyebrow_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Mali naslov {{ $language['label'] }} *</label>
                                        <input id="eyebrow_{{ $locale }}" name="eyebrow_{{ $locale }}" type="text" required value="{{ $topValue('eyebrow', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                        @error('eyebrow_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="title_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Glavni naslov {{ $language['label'] }} *</label>
                                        <input id="title_{{ $locale }}" name="title_{{ $locale }}" type="text" required value="{{ $topValue('title', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                        @error('title_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="intro_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Uvod {{ $language['label'] }} *</label>
                                        <textarea id="intro_{{ $locale }}" name="intro_{{ $locale }}" rows="4" required class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $topValue('intro', $locale) }}</textarea>
                                        @error('intro_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="body_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Glavni tekst {{ $language['label'] }} *</label>
                                        <textarea id="body_{{ $locale }}" name="body_{{ $locale }}" rows="12" required class="tinymce-editor w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $topValue('body', $locale) }}</textarea>
                                        @error('body_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="secondary_title_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Naslov detalja *</label>
                                            <input id="secondary_title_{{ $locale }}" name="secondary_title_{{ $locale }}" type="text" required value="{{ $topValue('secondary_title', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                            @error('secondary_title_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="values_title_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Naslov vrednosti *</label>
                                            <input id="values_title_{{ $locale }}" name="values_title_{{ $locale }}" type="text" required value="{{ $topValue('values_title', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                            @error('values_title_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="secondary_body_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">Tekst vrednosti {{ $language['label'] }} *</label>
                                        <textarea id="secondary_body_{{ $locale }}" name="secondary_body_{{ $locale }}" rows="4" required class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $topValue('secondary_body', $locale) }}</textarea>
                                        @error('secondary_body_'.$locale)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="grid gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="seo_title_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">SEO naslov</label>
                                            <input id="seo_title_{{ $locale }}" name="seo_title_{{ $locale }}" type="text" value="{{ $topValue('seo_title', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                        </div>
                                        <div>
                                            <label for="seo_description_{{ $locale }}" class="mb-1.5 block text-sm font-bold text-gray-700">SEO opis</label>
                                            <textarea id="seo_description_{{ $locale }}" name="seo_description_{{ $locale }}" rows="3" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $topValue('seo_description', $locale) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg">
                    <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-4 sm:px-6">
                        <h2 class="font-bold text-gray-900">Statistike</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Tri kratke stavke koje se prikazuju u hero delu</p>
                    </div>
                    <div class="grid gap-4 p-4 sm:p-6 lg:grid-cols-3">
                        @for ($index = 0; $index < 3; $index++)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <label for="stats_{{ $index }}_value" class="mb-1.5 block text-sm font-bold text-gray-700">Vrednost *</label>
                                <input id="stats_{{ $index }}_value" name="stats[{{ $index }}][value]" type="text" required value="{{ $statValue($index) }}" class="mb-4 w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                @foreach ($languages as $locale => $language)
                                    <label for="stats_{{ $index }}_label_{{ $locale }}" class="mb-1.5 block text-xs font-bold text-gray-600">Label {{ $language['label'] }} *</label>
                                    <input id="stats_{{ $index }}_label_{{ $locale }}" name="stats[{{ $index }}][label_{{ $locale }}]" type="text" required value="{{ $statLabel($index, $locale) }}" class="mb-3 w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg">
                    <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-4 sm:px-6">
                        <h2 class="font-bold text-gray-900">Vrednosti / proces</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Četiri kartice koje objašnjavaju način rada</p>
                    </div>
                    <div class="grid gap-4 p-4 sm:p-6 lg:grid-cols-2">
                        @for ($index = 0; $index < 4; $index++)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="mb-4 text-sm font-black text-primary-700">Kartica 0{{ $index + 1 }}</p>
                                @foreach ($languages as $locale => $language)
                                    <label for="values_{{ $index }}_title_{{ $locale }}" class="mb-1.5 block text-xs font-bold text-gray-600">Naslov {{ $language['label'] }} *</label>
                                    <input id="values_{{ $index }}_title_{{ $locale }}" name="values[{{ $index }}][title_{{ $locale }}]" type="text" required value="{{ $valueField($index, 'title', $locale) }}" class="mb-3 w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                    <label for="values_{{ $index }}_text_{{ $locale }}" class="mb-1.5 block text-xs font-bold text-gray-600">Tekst {{ $language['label'] }} *</label>
                                    <textarea id="values_{{ $index }}_text_{{ $locale }}" name="values[{{ $index }}][text_{{ $locale }}]" rows="3" required class="mb-4 w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $valueField($index, 'text', $locale) }}</textarea>
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <section class="space-y-6">
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg">
                    <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-4 sm:px-6">
                        <h2 class="font-bold text-gray-900">Slike</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Hero i detaljna slika stranice</p>
                    </div>
                    <div class="space-y-8 p-4 sm:p-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                                <label for="hero_image" class="mb-2 block text-sm font-bold text-gray-700">Hero slika</label>
                                @if ($heroPreview)
                                    <img src="{{ $heroPreview }}" alt="" class="mb-4 h-56 w-full rounded-xl object-cover shadow-sm">
                                @else
                                    <div class="mb-4 flex h-56 items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-white text-sm text-gray-400">Slika nije postavljena</div>
                                @endif
                                <input id="hero_image" name="hero_image" type="file" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-primary-700 hover:file:bg-primary-100">
                                <p class="mt-2 text-xs text-gray-500">Ostavite prazno ako ne želite da menjate postojeću sliku.</p>
                                @error('hero_image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                                <label for="secondary_image" class="mb-2 block text-sm font-bold text-gray-700">Detaljna slika</label>
                                @if ($secondaryPreview)
                                    <img src="{{ $secondaryPreview }}" alt="" class="mb-4 h-56 w-full rounded-xl object-cover shadow-sm">
                                @else
                                    <div class="mb-4 flex h-56 items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-white text-sm text-gray-400">Slika nije postavljena</div>
                                @endif
                                <input id="secondary_image" name="secondary_image" type="file" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-primary-700 hover:file:bg-primary-100">
                                <p class="mt-2 text-xs text-gray-500">Ostavite prazno ako ne želite da menjate postojeću sliku.</p>
                                @error('secondary_image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <h3 class="mb-1 text-sm font-bold text-gray-800">Opisi slika</h3>
                            <p class="mb-4 text-xs text-gray-500">Kratko opišite slike radi pristupačnosti i SEO optimizacije.</p>
                            <div class="space-y-5">
                                @foreach ($languages as $locale => $language)
                                    <div class="rounded-xl border border-gray-200 p-4">
                                        <p class="mb-3 text-sm font-bold text-primary-700"><span class="mr-1">{{ $language['flag'] }}</span> {{ $language['label'] }}</p>
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="hero_image_alt_{{ $locale }}" class="mb-1.5 block text-xs font-bold text-gray-600">Opis hero slike</label>
                                                <input id="hero_image_alt_{{ $locale }}" name="hero_image_alt_{{ $locale }}" type="text" value="{{ $topValue('hero_image_alt', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                            <div>
                                                <label for="secondary_image_alt_{{ $locale }}" class="mb-1.5 block text-xs font-bold text-gray-600">Opis detaljne slike</label>
                                                <input id="secondary_image_alt_{{ $locale }}" name="secondary_image_alt_{{ $locale }}" type="text" value="{{ $topValue('secondary_image_alt', $locale) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-4 z-10 flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white/95 p-4 shadow-xl backdrop-blur sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">Otkaži</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 px-7 py-3 text-sm font-bold text-white shadow-lg transition hover:from-primary-700 hover:to-primary-800">Sačuvaj izmene</button>
                </div>
            </section>
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
            height: 360,
            menubar: false,
            plugins: 'lists link code table wordcount fullscreen',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code fullscreen',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 15px; line-height: 1.75; }',
            branding: false,
            promotion: false,
            setup: function(editor) {
                editor.on('change keyup', function() {
                    editor.save();
                });
            }
        });
    });
</script>
@endpush
