@extends('layouts.admin')

@section('title', 'Pregled upita')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.inquiries.index') }}" class="text-primary-600 hover:text-primary-800">
            ← Nazad na upite
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Detalji upita</h2>
            @if($inquiry->is_read)
                <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">Pročitano</span>
            @else
                <span class="px-3 py-1 text-sm rounded-full bg-light-100 text-secondary-800">Novo</span>
            @endif
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Datum</label>
                <p class="text-gray-900">{{ $inquiry->created_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Ime</label>
                    <p class="text-gray-900">{{ $inquiry->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <p class="text-gray-900">
                        <a href="mailto:{{ $inquiry->email }}" class="text-primary-600 hover:text-primary-800">
                            {{ $inquiry->email }}
                        </a>
                    </p>
                </div>
            </div>

            @if($inquiry->phone)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Telefon</label>
                <p class="text-gray-900">
                    <a href="tel:{{ $inquiry->phone }}" class="text-primary-600 hover:text-primary-800">
                        {{ $inquiry->phone }}
                    </a>
                </p>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Poruka</label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $inquiry->message }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" data-confirm="Da li ste sigurni da želite da obrišete ovaj upit?" data-type="delete">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 border-2 border-red-300 rounded-xl text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 transition-all duration-200 font-bold shadow-sm hover:shadow-md hover:border-red-400">
                    Obriši upit
                </button>
            </form>
            
            <a href="{{ route('admin.inquiries.index') }}" class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition-all duration-200 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Nazad na listu
            </a>
        </div>
    </div>
</div>
@endsection
