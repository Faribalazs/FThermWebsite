@extends('layouts.admin')

@section('title', 'Izmeni sadržaj')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.homepage-contents.index') }}" class="text-primary-600 hover:text-primary-800">
            ← Nazad na sadržaj
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $homepage->key)) }}</h2>
            <p class="text-sm text-gray-600 mt-1">Ključ: <code class="bg-gray-100 px-2 py-1 rounded">{{ $homepage->key }}</code></p>
        </div>

        <form action="{{ route('admin.homepage-contents.update', $homepage) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- English -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">English</h3>
                <div>
                    <label for="value_en" class="block text-sm font-medium text-gray-700 mb-2">Sadržaj *</label>
                    <textarea id="value_en" name="value_en" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('value_en', $homepage->value['en'] ?? '') }}</textarea>
                    @error('value_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Serbian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Serbian (Српски)</h3>
                <div>
                    <label for="value_sr" class="block text-sm font-medium text-gray-700 mb-2">Sadržaj *</label>
                    <textarea id="value_sr" name="value_sr" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('value_sr', $homepage->value['sr'] ?? '') }}</textarea>
                    @error('value_sr')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Hungarian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Hungarian (Magyar)</h3>
                <div>
                    <label for="value_hu" class="block text-sm font-medium text-gray-700 mb-2">Sadržaj *</label>
                    <textarea id="value_hu" name="value_hu" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('value_hu', $homepage->value['hu'] ?? '') }}</textarea>
                    @error('value_hu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.homepage-contents.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Otkaži
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    Ažuriraj sadržaj
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
