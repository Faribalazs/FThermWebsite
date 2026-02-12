@extends('layouts.admin')

@section('title', 'Sadržaj naslove strane')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Sadržaj naslove strane</h1>
    <p class="text-gray-600 mt-2">Uredite tekstualni sadržaj koji se prikazuje na naslovnoj strani sajta.</p>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="grid gap-4">
    @forelse($contents as $content)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ ucfirst(str_replace('_', ' ', $content->key)) }}</h3>
                <p class="text-sm text-gray-600 mb-3">Ključ: <code class="bg-gray-100 px-2 py-1 rounded">{{ $content->key }}</code></p>
                <div class="space-y-2">
                    <div>
                        <span class="text-xs font-medium text-gray-500">EN:</span>
                        <p class="text-sm text-gray-700 line-clamp-2">{{ $content->value['en'] ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-500">SR:</span>
                        <p class="text-sm text-gray-700 line-clamp-2">{{ $content->value['sr'] ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-500">HU:</span>
                        <p class="text-sm text-gray-700 line-clamp-2">{{ $content->value['hu'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.homepage-contents.edit', $content) }}" class="ml-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition text-sm">
                Izmeni
            </a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-500">
        Nema sadržaja
    </div>
    @endforelse
</div>
@endsection
