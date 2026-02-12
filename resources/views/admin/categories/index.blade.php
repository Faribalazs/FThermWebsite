@extends('layouts.admin')

@section('title', 'Kategorije proizvoda')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Kategorije proizvoda</h1>
    <a href="{{ route('admin.product-categories.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition">
        Dodaj novu kategoriju
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naziv</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proizvoda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $category->name['sr'] ?? $category->name['en'] ?? '' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $category->products_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($category->active)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktivan</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Neaktivan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                        <a href="{{ route('admin.product-categories.edit', $category) }}" class="text-primary-600 hover:text-primary-800">Izmeni</a>
                        <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Obriši</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Nema kategorija</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $categories->links() }}
    </div>
</div>
@endsection
