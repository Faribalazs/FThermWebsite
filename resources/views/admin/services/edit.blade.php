@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.services.index') }}" class="text-primary-600 hover:text-primary-800">
            ← Back to Services
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Service</h2>

        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- English -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">English</h3>
                <div class="space-y-4">
                    <div>
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" id="title_en" name="title_en" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('title_en', $service->title['en'] ?? '') }}">
                        @error('title_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description_en" name="description_en" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_en', $service->description['en'] ?? '') }}</textarea>
                        @error('description_en')
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
                        <label for="title_sr" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" id="title_sr" name="title_sr" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('title_sr', $service->title['sr'] ?? '') }}">
                        @error('title_sr')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_sr" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description_sr" name="description_sr" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_sr', $service->description['sr'] ?? '') }}</textarea>
                        @error('description_sr')
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
                        <label for="title_hu" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" id="title_hu" name="title_hu" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('title_hu', $service->title['hu'] ?? '') }}">
                        @error('title_hu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description_hu" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description_hu" name="description_hu" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description_hu', $service->description['hu'] ?? '') }}</textarea>
                        @error('description_hu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Other Fields -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (emoji or text)</label>
                        <input type="text" id="icon" name="icon" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="🔥 or SVG" value="{{ old('icon', $service->icon) }}">
                        @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order *</label>
                        <input type="number" id="order" name="order" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('order', $service->order) }}">
                        @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="active" value="1" {{ old('active', $service->active) ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible on website)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.services.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    Update Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
