@extends('layouts.admin')

@section('title', 'Kreiraj kategoriju')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.product-categories.index') }}" class="text-primary-600 hover:text-primary-800">
            ← Nazad na kategorije
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Kreiraj novu kategoriju</h2>

        <form action="{{ route('admin.product-categories.store') }}" method="POST">
            @csrf

            <!-- English -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">English</h3>
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                    <input type="text" id="name_en" name="name_en" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_en') }}">
                    @error('name_en')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Serbian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Serbian (Српски)</h3>
                <div>
                    <label for="name_sr" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                    <input type="text" id="name_sr" name="name_sr" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_sr') }}">
                    @error('name_sr')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Hungarian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Hungarian (Magyar)</h3>
                <div>
                    <label for="name_hu" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                    <input type="text" id="name_hu" name="name_hu" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_hu') }}">
                    @error('name_hu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Podešavanja</h3>
                <div class="space-y-4">
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL) *</label>
                        <input type="text" id="slug" name="slug" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('slug') }}" placeholder="klima-uredjaji">
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Samo mala slova, brojevi i crtice</p>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="active" name="active" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" {{ old('active', true) ? 'checked' : '' }}>
                        <label for="active" class="ml-2 text-sm text-gray-700">Aktivna</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.product-categories.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Otkaži
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    Kreiraj kategoriju
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
