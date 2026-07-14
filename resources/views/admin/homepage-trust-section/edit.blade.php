@extends('layouts.admin')

@section('title', 'Zašto FTHERM?')

@php
    $languages = [
        'sr' => ['label' => 'Srpski', 'flag' => '🇷🇸'],
        'en' => ['label' => 'English', 'flag' => '🇬🇧'],
        'hu' => ['label' => 'Magyar', 'flag' => '🇭🇺'],
    ];
    $localizedValue = fn (string $field, string $locale) => old("{$field}_{$locale}", $trustSection->{$field}[$locale] ?? '');
    $metricValue = fn (int $index, string $field, ?string $locale = null) => old(
        $locale ? "metrics.{$index}.{$field}_{$locale}" : "metrics.{$index}.{$field}",
        $locale ? ($trustSection->metrics[$index][$field][$locale] ?? '') : ($trustSection->metrics[$index][$field] ?? '')
    );
    $itemValue = fn (int $index, string $field, string $locale) => old(
        "items.{$index}.{$field}_{$locale}",
        $trustSection->items[$index][$field][$locale] ?? ''
    );
@endphp

@section('content')
<div class="animate-fade-in-up" x-data="{ langTab: 'sr' }">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 shadow-lg">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 lg:text-3xl">Zašto klijenti biraju FTHERM?</h1>
                <p class="mt-0.5 text-sm text-gray-500">Uredite sadržaj sekcije na početnoj stranici</p>
            </div>
        </div>
        <a href="{{ route('home', ['locale' => 'sr']) }}" target="_blank" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">Pogledaj početnu</a>
    </div>

    <form action="{{ route('admin.homepage-trust-section.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg">
            <div class="flex overflow-x-auto border-b border-gray-200 px-4 sm:px-6">
                @foreach ($languages as $locale => $language)
                    <button type="button" @click="langTab = '{{ $locale }}'" :class="langTab === '{{ $locale }}' ? 'border-primary-500 bg-primary-50/50 text-primary-600' : 'border-transparent text-gray-500'" class="flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-3 text-sm font-bold transition"><span>{{ $language['flag'] }}</span>{{ $language['label'] }}</button>
                @endforeach
            </div>

            @foreach ($languages as $locale => $language)
                <div x-show="langTab === '{{ $locale }}'" x-transition class="space-y-6 p-4 sm:p-6">
                    <div class="grid gap-5 lg:grid-cols-2">
                        <div><label class="mb-1.5 block text-sm font-bold text-gray-700">Mali naslov *</label><input name="eyebrow_{{ $locale }}" value="{{ $localizedValue('eyebrow', $locale) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"></div>
                        <div><label class="mb-1.5 block text-sm font-bold text-gray-700">Glavni naslov *</label><input name="title_{{ $locale }}" value="{{ $localizedValue('title', $locale) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"></div>
                    </div>
                    <div><label class="mb-1.5 block text-sm font-bold text-gray-700">Uvodni tekst *</label><textarea name="intro_{{ $locale }}" rows="4" required class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">{{ $localizedValue('intro', $locale) }}</textarea></div>

                    <div>
                        <h2 class="mb-3 font-bold text-gray-900">Tri koraka</h2>
                        <div class="grid gap-4 lg:grid-cols-3">
                            @for ($index = 0; $index < 3; $index++)
                                <div class="rounded-xl border border-gray-200 p-4">
                                    @if ($locale === 'sr')
                                        <label class="mb-1.5 block text-xs font-bold text-gray-600">Vrednost *</label>
                                        <input name="metrics[{{ $index }}][value]" value="{{ $metricValue($index, 'value') }}" required class="mb-3 w-full rounded-xl border-gray-300 text-sm">
                                    @endif
                                    <label class="mb-1.5 block text-xs font-bold text-gray-600">Naziv *</label>
                                    <input name="metrics[{{ $index }}][label_{{ $locale }}]" value="{{ $metricValue($index, 'label', $locale) }}" required class="w-full rounded-xl border-gray-300 text-sm">
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <h2 class="mb-3 font-bold text-gray-900">Kartice prednosti</h2>
                        <div class="grid gap-4 lg:grid-cols-2">
                            @for ($index = 0; $index < 4; $index++)
                                <div class="rounded-xl border border-gray-200 p-4">
                                    <p class="mb-3 text-sm font-black text-primary-700">Kartica 0{{ $index + 1 }}</p>
                                    <label class="mb-1.5 block text-xs font-bold text-gray-600">Naslov *</label>
                                    <input name="items[{{ $index }}][title_{{ $locale }}]" value="{{ $itemValue($index, 'title', $locale) }}" required class="mb-3 w-full rounded-xl border-gray-300 text-sm">
                                    <label class="mb-1.5 block text-xs font-bold text-gray-600">Tekst *</label>
                                    <textarea name="items[{{ $index }}][text_{{ $locale }}]" rows="3" required class="w-full rounded-xl border-gray-300 text-sm">{{ $itemValue($index, 'text', $locale) }}</textarea>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center rounded-xl bg-primary-600 px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:bg-primary-700">Sačuvaj izmene</button>
        </div>
    </form>
</div>
@endsection
