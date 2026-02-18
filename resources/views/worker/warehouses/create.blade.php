@extends('layouts.worker')

@section('title', 'Dodaj Skladište')

@section('content')
<div class="p-3 sm:p-4 md:p-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('worker.warehouses.index') }}" 
                   class="text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dodaj Skladište</h1>
            </div>
            <p class="text-sm sm:text-base text-gray-600">Kreirajte novo skladište</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <form action="{{ route('worker.warehouses.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Naziv <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('name') border-red-500 @enderror"
                        placeholder="Unesite naziv skladišta"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Opis
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('description') border-red-500 @enderror"
                        placeholder="Unesite opis skladišta (opcionalno)"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            id="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        >
                        <span class="ml-2 text-sm font-medium text-gray-700">Skladište je aktivno</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <button 
                        type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition"
                    >
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Sačuvaj
                    </button>
                    <a 
                        href="{{ route('worker.warehouses.index') }}"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition text-center"
                    >
                        Otkaži
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
