@extends('layouts.admin')

@section('title', 'Kreiraj proizvod')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-primary-600 hover:text-primary-800">
            ← Nazad na proizvode
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Kreiraj novi proizvod</h2>

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <!-- Category -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Osnovno</h3>
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategorija *</label>
                    <select id="category_id" name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Izaberite kategoriju</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name['sr'] ?? $category->name['en'] ?? '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- English -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">English</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                        <input type="text" id="name_en" name="name_en" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_en') }}">
                        @error('name_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">Opis *</label>
                        <textarea id="description_en" name="description_en" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_en') }}</textarea>
                        @error('description_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="technical_specs_en" class="block text-sm font-medium text-gray-700 mb-2">Tehničke specifikacije</label>
                        <textarea id="technical_specs_en" name="technical_specs_en" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('technical_specs_en') }}</textarea>
                        @error('technical_specs_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Serbian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Serbian (Српски)</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name_sr" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                        <input type="text" id="name_sr" name="name_sr" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_sr') }}">
                        @error('name_sr')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_sr" class="block text-sm font-medium text-gray-700 mb-2">Opis *</label>
                        <textarea id="description_sr" name="description_sr" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_sr') }}</textarea>
                        @error('description_sr')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="technical_specs_sr" class="block text-sm font-medium text-gray-700 mb-2">Tehničke specifikacije</label>
                        <textarea id="technical_specs_sr" name="technical_specs_sr" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('technical_specs_sr') }}</textarea>
                        @error('technical_specs_sr')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hungarian -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Hungarian (Magyar)</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name_hu" class="block text-sm font-medium text-gray-700 mb-2">Naziv *</label>
                        <input type="text" id="name_hu" name="name_hu" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name_hu') }}">
                        @error('name_hu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_hu" class="block text-sm font-medium text-gray-700 mb-2">Opis *</label>
                        <textarea id="description_hu" name="description_hu" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_hu') }}</textarea>
                        @error('description_hu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="technical_specs_hu" class="block text-sm font-medium text-gray-700 mb-2">Tehničke specifikacije</label>
                        <textarea id="technical_specs_hu" name="technical_specs_hu" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('technical_specs_hu') }}</textarea>
                        @error('technical_specs_hu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Podešavanja</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL) *</label>
                        <input type="text" id="slug" name="slug" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('slug') }}" placeholder="klima-uređaj-model-x">
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Cena (€)</label>
                        <input type="number" step="0.01" id="price" name="price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('price') }}">
                        @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Redosled *</label>
                        <input type="number" id="order" name="order" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('order', 0) }}">
                        @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                        <div class="flex items-center h-[42px]">
                            <input type="checkbox" id="active" name="active" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" {{ old('active', true) ? 'checked' : '' }}>
                            <label for="active" class="ml-2 text-sm text-gray-700">Aktivan</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Otkaži
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    Kreiraj proizvod
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
