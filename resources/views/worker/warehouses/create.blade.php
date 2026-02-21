@extends('layouts.worker')

@section('title', 'Dodaj Skladište')

@section('content')
<div class="p-3 sm:p-4 md:p-6">
    <div class="max-w-3xl mx-auto">

        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 mb-4 sm:mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('worker.warehouses.index') }}"
                       class="bg-white/20 p-2 rounded-xl backdrop-blur-sm hover:bg-white/30 transition active:scale-95">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Dodaj Skladište</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Kreirajte novo skladište</p>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="mx-4 sm:mx-8 mt-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>Molimo ispravite greške u formi.</div>
                </div>
            @endif

            <!-- Form -->
            <div class="p-4 sm:p-6 md:p-8">
                <form action="{{ route('worker.warehouses.store') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Naziv <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white transition-all @error('name') border-red-400 bg-red-50 @enderror"
                            placeholder="Unesite naziv skladišta"
                        >
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-5">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Opis
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white transition-all resize-none @error('description') border-red-400 bg-red-50 @enderror"
                            placeholder="Unesite opis skladišta (opcionalno)"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Is Active Toggle -->
                    <div class="mb-5">
                        <label for="is_active" class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-900">Status skladišta</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Aktivna skladišta su vidljiva za korišćenje</p>
                                </div>
                            </div>
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    id="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="sr-only peer"
                                >
                                <div class="w-11 h-6 bg-gray-300 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col-reverse sm:flex-row gap-3 pt-5 border-t border-gray-100">
                        <a
                            href="{{ route('worker.warehouses.index') }}"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition text-sm active:scale-95"
                        >
                            Otkaži
                        </a>
                        <button
                            type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm active:scale-95"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Sačuvaj Skladište
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
