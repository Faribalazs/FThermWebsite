@extends('layouts.worker')

@section('title', 'Fakture')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-0 mb-4 sm:mb-6 animate-fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-clip-text">
                    Fakture
                </h1>
                <p class="text-sm text-gray-600 mt-1">Pregled kreiranih faktura</p>
            </div>
            <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg shadow-md border border-gray-200">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs sm:text-sm font-semibold text-gray-700">{{ $invoices->total() }} Faktura</span>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-3 sm:p-6 mb-4 sm:mb-6 animate-slide-in">
            <form method="GET" action="{{ route('worker.invoices.index') }}" class="space-y-4">
                <!-- Search -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Pretraga</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               id="invoice-search"
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Pretražite..." 
                               class="form-input w-full pl-9 sm:pl-10 pr-9 sm:pr-10 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <div id="search-loader" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                            <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filters Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Location Filter -->
                    <x-custom-select
                        name="location"
                        id="location_filter"
                        :selected="request('location')"
                        :selectedText="request('location') ?: ''"
                        :options="collect(['' => 'Sve lokacije'])->merge($locations->mapWithKeys(fn($loc) => [$loc => $loc]))->toArray()"
                        label="Lokacija"
                    />

                    <!-- Date From -->
                    <x-custom-datepicker
                        name="date_from"
                        id="invoice_date_from"
                        :value="request('date_from', '')"
                        label="Datum od"
                        placeholder="Izaberite datum"
                    />

                    <!-- Date To -->
                    <x-custom-datepicker
                        name="date_to"
                        id="invoice_date_to"
                        :value="request('date_to', '')"
                        label="Datum do"
                        placeholder="Izaberite datum"
                    />

                    <!-- Sort By -->
                    <x-custom-select
                        name="sort_by"
                        id="sort_by_filter"
                        :selected="request('sort_by', 'created_at')"
                        :selectedText="[
                            'created_at' => 'Datumu',
                            'invoice_company_name' => 'Imenu',
                            'total_amount' => 'Iznosu',
                            'invoice_number' => 'Broju fakture'
                        ][request('sort_by', 'created_at')] ?? 'Datumu'"
                        :options="[
                            'created_at' => 'Datumu',
                            'invoice_company_name' => 'Imenu',
                            'total_amount' => 'Iznosu',
                            'invoice_number' => 'Broju fakture'
                        ]"
                        label="Sortiraj po"
                    />
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Cenovni opseg (RSD)</label>
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <input type="number" 
                               name="price_from" 
                               value="{{ request('price_from') }}"
                               placeholder="Od" 
                               step="0.01"
                               class="form-input w-full px-3 py-2 sm:px-4 sm:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <input type="number" 
                               name="price_to" 
                               value="{{ request('price_to') }}"
                               placeholder="Do" 
                               step="0.01"
                               class="form-input w-full px-3 py-2 sm:px-4 sm:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Primeni Filtere
                    </button>
                    <a href="{{ route('worker.invoices.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Resetuj
                    </a>
                    <button type="button" 
                            onclick="var input = document.querySelector('input[name=sort_order]'); input.value = input.value === 'asc' ? 'desc' : 'asc'; this.closest('form').submit();"
                            class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ request('sort_order') == 'asc' ? '' : 'rotate-180' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        <span class="inline">{{ request('sort_order') == 'asc' ? 'Rastuće' : 'Opadajuće' }}</span>
                    </button>
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">
                </div>
            </form>
        </div>

        <!-- Invoices Table -->
        @if($invoices->count() > 0)
        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-xl shadow-enhanced border border-gray-200 overflow-hidden animate-scale-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 modern-table">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Broj Fakture</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Firma/Klijent</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Lokacija</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Datum</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tip</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Iznos</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Akcije</th>
                        </tr>
                    </thead>
                    <tbody id="invoices-table-body" class="divide-y divide-gray-200 bg-white">
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-light-100 to-light-200 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $invoice->invoice_number }}</div>
                                        <div class="text-xs text-gray-500">{{ $invoice->client_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $invoice->invoice_company_name }}</div>
                                @if($invoice->invoice_pib)
                                <div class="text-xs text-gray-500">PIB: {{ $invoice->invoice_pib }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $invoice->location }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $invoice->created_at->format('d.m.Y') }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $invoice->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($invoice->invoice_type == 'fizicko_lice')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Fizičko Lice
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                    Pravno Lice
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-lg font-bold text-primary-600">{{ number_format($invoice->total_amount, 2) }}</div>
                                <div class="text-xs text-gray-500">RSD</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('worker.work-orders.show', $invoice) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                                       title="Pregled">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('worker.work-orders.invoice', $invoice) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                                       title="Faktura">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('worker.work-orders.invoice.download', $invoice) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                                       title="Preuzmi PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($invoices->hasPages())
            <div id="pagination-container" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
        
        <!-- Mobile Card View -->
        <div class="md:hidden space-y-3 animate-scale-in">
            @foreach($invoices as $invoice)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-4 py-3 border-b border-primary-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $invoice->invoice_number }}</div>
                                <div class="text-xs text-gray-600">{{ $invoice->client_name }}</div>
                            </div>
                        </div>
                        @if($invoice->invoice_type == 'fizicko_lice')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            Fizičko
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                            Pravno
                        </span>
                        @endif
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="p-4 space-y-3">
                    <!-- Company Info -->
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Firma/Klijent</div>
                        <div class="text-sm font-semibold text-gray-900">{{ $invoice->invoice_company_name }}</div>
                        @if($invoice->invoice_pib)
                        <div class="text-xs text-gray-500">PIB: {{ $invoice->invoice_pib }}</div>
                        @endif
                    </div>
                    
                    <!-- Location and Date -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Lokacija</div>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-light-50 text-secondary-700 border border-light-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $invoice->location }}
                            </span>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Datum</div>
                            <div class="flex items-center gap-1 text-sm text-gray-600">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $invoice->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Amount -->
                    <div class="pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">Ukupan iznos</div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-primary-600">{{ number_format($invoice->total_amount, 2) }}</div>
                                <div class="text-xs text-gray-500">RSD</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="grid grid-cols-3 gap-2 pt-3">
                        <a href="{{ route('worker.work-orders.show', $invoice) }}" 
                           class="inline-flex items-center justify-center gap-1 px-3 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-xs font-semibold rounded-lg shadow-md hover:shadow-lg active:scale-95 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>Pregled</span>
                        </a>
                        <a href="{{ route('worker.work-orders.invoice', $invoice) }}" 
                           class="inline-flex items-center justify-center gap-1 px-3 py-2.5 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white text-xs font-semibold rounded-lg shadow-md hover:shadow-lg active:scale-95 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Faktura</span>
                        </a>
                        <a href="{{ route('worker.work-orders.invoice.download', $invoice) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center gap-1 px-3 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-xs font-semibold rounded-lg shadow-md hover:shadow-lg active:scale-95 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>PDF</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Mobile Pagination -->
            @if($invoices->hasPages())
            <div class="bg-white rounded-xl shadow-md border border-gray-200 px-4 py-3">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-12 text-center animate-fade-in">
            <svg class="w-16 h-16 sm:w-24 sm:h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">Nema Faktura</h3>
            <p class="text-sm sm:text-base text-gray-500 mb-4">{{ request()->hasAny(['search', 'location', 'date_from', 'date_to', 'price_from', 'price_to']) ? 'Nema faktura koje zadovoljavaju kriterijume pretrage.' : 'Još uvek nema kreiranih faktura.' }}</p>
            @if(!request()->hasAny(['search', 'location', 'date_from', 'date_to', 'price_from', 'price_to']))
            <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center justify-center gap-2 mt-4 px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Kreiraj Radni Nalog
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
let searchTimeout;
const searchInput = document.getElementById('invoice-search');
const tableBody = document.getElementById('invoices-table-body');
const paginationContainer = document.getElementById('pagination-container');
const searchLoader = document.getElementById('search-loader');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 300);
    });
}

// Handle pagination clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('#pagination-container a')) {
        e.preventDefault();
        const url = e.target.closest('a').href;
        fetchResults(url);
    }
});

function performSearch() {
    const searchValue = searchInput.value;
    const form = document.querySelector('form');
    const formData = new FormData(form);
    formData.set('search', searchValue);
    
    const params = new URLSearchParams(formData);
    const url = `{{ route('worker.invoices.index') }}?${params.toString()}`;
    
    fetchResults(url);
}

function fetchResults(url) {
    searchLoader.classList.remove('hidden');
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        tableBody.innerHTML = data.html;
        paginationContainer.innerHTML = data.pagination;
        searchLoader.classList.add('hidden');
    })
    .catch(error => {
        console.error('Search error:', error);
        searchLoader.classList.add('hidden');
    });
}
</script>
@endpush

@endsection
