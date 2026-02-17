@extends('layouts.admin')

@section('title', 'Upiti')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Upiti sa sajta</h1>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($inquiries as $inquiry)
                <tr class="hover:bg-gray-50 {{ !$inquiry->is_read ? 'bg-light-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $inquiry->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $inquiry->name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <a href="mailto:{{ $inquiry->email }}" class="text-primary-600 hover:text-primary-800">
                            {{ $inquiry->email }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        @if($inquiry->phone)
                            <a href="tel:{{ $inquiry->phone }}" class="text-primary-600 hover:text-primary-800">
                                {{ $inquiry->phone }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($inquiry->is_read)
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Pročitano</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-light-100 text-secondary-800">Novo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-primary-600 hover:text-primary-800">Pregledaj</a>
                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Obriši</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Nema upita</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $inquiries->links() }}
    </div>
</div>
@endsection
