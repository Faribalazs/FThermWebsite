@extends('layouts.admin')

@section('title', 'Kontrolna tabla')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up">
    <!-- Stats Cards -->
    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-2">Ukupno proizvoda</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">{{ $stats['total_products'] }}</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-primary-100 to-primary-200 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-2">Ukupno usluga</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">{{ $stats['total_services'] }}</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-green-100 to-green-200 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-2">Ukupno upita</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent">{{ $stats['total_inquiries'] }}</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-purple-100 to-purple-200 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-2">Nepročitani upiti</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-secondary-600 to-secondary-700 bg-clip-text text-transparent">{{ $stats['unread_inquiries'] }}</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-secondary-100 to-secondary-200 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Inquiries -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden animate-fade-in-up">
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2 rounded-xl">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Nedavni upiti</h3>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1 hover:gap-2 transition-all">
                Vidi sve
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ime</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Datum</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($recent_inquiries as $inquiry)
                <tr class="hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200 group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center text-primary-700 font-bold text-sm mr-3">
                                {{ substr($inquiry->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $inquiry->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $inquiry->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $inquiry->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($inquiry->is_read)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                Pročitano
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-secondary-500 to-secondary-600 text-white shadow-lg animate-pulse">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                                Novo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="inline-flex items-center gap-1 font-medium text-primary-600 hover:text-primary-700 group-hover:gap-2 transition-all">
                            Pregledaj
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">Nema upita</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
    <a href="{{ route('admin.products.create') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="relative flex items-center">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative bg-gradient-to-br from-primary-500 to-primary-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="ml-5">
                <p class="text-sm text-gray-500 font-medium mb-1">Add New</p>
                <p class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Product</p>
            </div>
            <div class="ml-auto">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.services.create') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="relative flex items-center">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="ml-5">
                <p class="text-sm text-gray-500 font-medium mb-1">Add New</p>
                <p class="text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">Service</p>
            </div>
            <div class="ml-auto">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.inquiries.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="relative flex items-center">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="ml-5">
                <p class="text-sm text-gray-500 font-medium mb-1">View All</p>
                <p class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Inquiries</p>
            </div>
            <div class="ml-auto">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    </a>
</div>
@endsection
