@extends('layouts.worker')

@section('title', 'Skladišta')

@section('content')
<div class="p-3 sm:p-4 md:p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 mb-4 sm:mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2.5 rounded-xl backdrop-blur-sm">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-white">Skladišta</h1>
                            <p class="text-primary-100 text-xs sm:text-sm mt-0.5">{{ $warehouses->count() }} {{ $warehouses->count() == 1 ? 'skladište' : 'skladišta' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('worker.warehouses.create') }}"
                       class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-3 sm:px-5 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="hidden sm:inline">Dodaj Skladište</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-4 sm:mx-8 mt-4 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-4 sm:mx-8 mt-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="p-4 sm:p-6">
                @if($warehouses->count() > 0)
                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-3">
                        @foreach($warehouses as $warehouse)
                            @php
                                $itemCount = $warehouse->inventories()->where('quantity', '>', 0)->count();
                            @endphp
                            <div class="group relative bg-white border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-lg transition-all duration-200 overflow-hidden">
                                {{-- Status accent bar --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $warehouse->is_active ? 'bg-green-500' : 'bg-gray-300' }} rounded-l-xl"></div>

                                <div class="p-4 pl-5">
                                    <a href="{{ route('worker.warehouses.show', $warehouse) }}" class="block">
                                        <div class="flex items-start gap-3">
                                            {{-- Info --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <h3 class="font-bold text-gray-900 text-base truncate">{{ $warehouse->name }}</h3>
                                                    @if($warehouse->is_active)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 flex-shrink-0">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                            Aktivno
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 flex-shrink-0">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                            Neaktivno
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($warehouse->description)
                                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $warehouse->description }}</p>
                                                @endif

                                                {{-- Stats row --}}
                                                <div class="mt-2.5 flex items-center gap-4 text-sm text-gray-500">
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                        <span class="font-semibold text-gray-700">{{ $itemCount }}</span> artikala
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    {{-- Mobile Action Bar --}}
                                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                                        <a href="{{ route('worker.warehouses.show', $warehouse) }}"
                                           class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-primary-50 text-primary-700 font-semibold rounded-lg text-sm transition-colors active:bg-primary-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Pregledaj
                                        </a>
                                        <a href="{{ route('worker.warehouses.edit', $warehouse) }}"
                                           class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm transition-colors active:bg-gray-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Izmeni
                                        </a>
                                        <form action="{{ route('worker.warehouses.destroy', $warehouse) }}" method="POST"
                                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovo skladište?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="flex items-center justify-center gap-2 py-2.5 px-4 bg-red-50 text-red-600 font-semibold rounded-lg text-sm transition-colors active:bg-red-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-hidden rounded-xl border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naziv</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Broj Artikala</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($warehouses as $warehouse)
                                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('worker.warehouses.show', $warehouse) }}'">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-lg {{ $warehouse->is_active ? 'bg-gradient-to-br from-primary-500 to-primary-600' : 'bg-gray-200' }} flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm font-semibold text-gray-900">{{ $warehouse->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500 max-w-xs truncate">{{ $warehouse->description ?: '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($warehouse->is_active)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                        Aktivno
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                        Neaktivno
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $warehouse->inventories()->where('quantity', '>', 0)->count() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="event.stopPropagation()">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('worker.warehouses.edit', $warehouse) }}"
                                                       class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 transition"
                                                       title="Izmeni">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('worker.warehouses.destroy', $warehouse) }}"
                                                          method="POST"
                                                          class="inline"
                                                          onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovo skladište?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition" title="Obriši">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="py-12 sm:py-16 text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg font-bold text-gray-900 mb-1">Nema skladišta</p>
                        <p class="text-sm text-gray-500 mb-5 max-w-sm mx-auto">Dodajte prvo skladište da biste počeli sa upravljanjem materijala.</p>
                        <a href="{{ route('worker.warehouses.create') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Dodaj Skladište
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
