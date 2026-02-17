@extends('layouts.admin')

@section('title', 'Izmeni Radnika')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Izmeni radnika</h1>
            <p class="mt-2 text-sm text-gray-500">Ažurirajte informacije za nalog: <span class="font-semibold text-primary-600">{{ $worker->name }}</span></p>
        </div>
        <a href="{{ route('admin.workers.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na listu
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('admin.workers.update', $worker) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                     <!-- User Icon Section (optional visual) -->
                     <div class="flex items-center space-x-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Podaci o Korisniku</h3>
                            <p class="text-sm text-gray-500">Izmenite lične podatke ili promenite lozinku.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Ime i Prezime <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow shadow-sm placeholder-gray-400" 
                                value="{{ old('name', $worker->name) }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Adresa <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow shadow-sm placeholder-gray-400" 
                                value="{{ old('email', $worker->email) }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Nova Lozinka</label>
                            <input type="password" id="password" name="password" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow shadow-sm" 
                                placeholder="••••••••">
                            <p class="mt-1 text-xs text-gray-500">Ostavite prazno ako ne želite da menjate lozinku.</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Potvrdi Novu Lozinku</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow shadow-sm"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="pt-6 border-t border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Dozvole Pristupa</h3>
                        <p class="text-sm text-gray-500 mt-1">Izaberite koje stranice radnik može videti i pristupiti.</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach($availablePermissions as $key => $label)
                            <label class="flex items-center p-3 bg-white rounded-lg border-2 border-gray-200 hover:border-primary-400 cursor-pointer transition-all group">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                    {{ in_array($key, old('permissions', $worker->permissions ?? [])) ? 'checked' : '' }}
                                    class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-2 focus:ring-primary-500">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-primary-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-4 italic">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Radnik će videti samo označene sekcije u svom sistemu.
                        </p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.workers.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-sm transition">
                        Otkaži
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-sm transition">
                        Sačuvaj izmene
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

