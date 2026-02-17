@extends('layouts.worker')

@section('title', 'Pregled Radnog Naloga')

@section('content')
<div class="p-3 sm:p-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Pregled</li>
        </ol>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in alert-success">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Work Order Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <div class="text-white flex-1">
                    <p class="text-xs sm:text-sm opacity-90">Radni Nalog</p>
                    <h1 class="text-xl sm:text-3xl font-bold mt-1">
                        @if($workOrder->client_type === 'pravno_lice')
                            {{ $workOrder->company_name }}
                        @else
                            {{ $workOrder->client_name }}
                        @endif
                    </h1>
                    <p class="text-xs sm:text-sm opacity-90 mt-1 sm:mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $workOrder->location }}
                    </p>
                    @if($workOrder->km_to_destination)
                    <p class="text-xs sm:text-sm opacity-90 mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ number_format($workOrder->km_to_destination, 2) }} km
                    </p>
                    @endif
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    @if ($workOrder->has_invoice)
                    <span class="bg-green-500 text-white text-xs sm:text-sm font-semibold px-3 sm:px-4 py-1.5 sm:py-2 rounded-full whitespace-nowrap inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Fakturisano
                    </span>
                    @endif
                    <a href="{{ route('worker.work-orders.edit', $workOrder) }}" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow-lg hover:shadow-xl transition-all text-xs sm:text-sm border border-blue-200 hover:bg-blue-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="hidden sm:inline">Uredi</span>
                        <span class="sm:hidden">Uredi</span>
                    </a>
                    <a href="{{ route('worker.work-orders.export-pdf', $workOrder) }}" class="inline-flex items-center justify-center gap-2 bg-white text-primary-700 font-semibold px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow-lg hover:shadow-xl transition-all text-xs sm:text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="hidden sm:inline">Preuzmi PDF</span>
                        <span class="sm:hidden">PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="p-3 sm:p-8">
            <!-- Client Information Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($workOrder->client_type === 'pravno_lice')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        @endif
                    </svg>
                    Informacije o Klijentu
                    <span class="text-xs font-normal bg-primary-100 text-primary-700 px-2 py-1 rounded-full">
                        {{ $workOrder->client_type === 'pravno_lice' ? 'Pravno Lice' : 'Fizičko Lice' }}
                    </span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($workOrder->client_type === 'pravno_lice')
                        @if($workOrder->company_name)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">Naziv Kompanije</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->company_name }}</p>
                        </div>
                        @endif
                        @if($workOrder->pib)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">PIB</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->pib }}</p>
                        </div>
                        @endif
                        @if($workOrder->maticni_broj)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">Matični Broj</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->maticni_broj }}</p>
                        </div>
                        @endif
                        @if($workOrder->company_address)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">Adresa</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->company_address }}</p>
                        </div>
                        @endif
                    @else
                        @if($workOrder->client_name)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">Ime i Prezime</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->client_name }}</p>
                        </div>
                        @endif
                        @if($workOrder->client_address)
                        <div>
                            <p class="text-xs text-gray-600 mb-1 font-semibold">Adresa</p>
                            <p class="text-sm text-gray-900">{{ $workOrder->client_address }}</p>
                        </div>
                        @endif
                    @endif
                    @if($workOrder->client_phone)
                    <div>
                        <p class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telefon
                        </p>
                        <p class="text-sm text-gray-900">{{ $workOrder->client_phone }}</p>
                    </div>
                    @endif
                    @if($workOrder->client_email)
                    <div>
                        <p class="text-xs text-gray-600 mb-1 font-semibold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email
                        </p>
                        <p class="text-sm text-gray-900">{{ $workOrder->client_email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6 mb-6 sm:mb-8">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Datum kreiranja</p>
                    <p class="text-sm sm:text-lg font-semibold">{{ $workOrder->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Status</p>
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $workOrder->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($workOrder->status) }}
                    </span>
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
                @foreach ($workOrder->sections as $section)
                <div class="border border-gray-200 rounded-lg p-3 sm:p-6 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 sm:gap-0 mb-3 sm:mb-4">
                        <h2 class="text-base sm:text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $section->title }}
                        </h2>
                        @if($section->hours_spent)
                        <div class="flex items-center gap-1 sm:gap-2 bg-blue-100 px-2 sm:px-3 py-1 rounded-full">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-800 font-semibold text-xs sm:text-sm">{{ number_format($section->hours_spent, 2) }}h</span>
                        </div>
                        @endif
                    </div>

                    @if($section->items->count() > 0)
                    <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Proizvod</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">J. Cena</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Kol.</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-right text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Ukupno</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($section->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}
                                            <span class="text-gray-500 text-xs ml-1">({{ $item->product->unit }})</span>
                                        </td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600 whitespace-nowrap">{{ number_format($item->price_at_time, 2) }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-bold text-gray-900 text-right whitespace-nowrap">{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @elseif($section->service_price && $section->service_price > 0)
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 sm:p-6 border-2 border-blue-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-500 text-white rounded-full p-2 sm:p-3">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs sm:text-sm text-blue-700 font-semibold">Cena usluge</p>
                                    <p class="text-lg sm:text-2xl font-bold text-blue-900">{{ number_format($section->service_price, 2) }} RSD</p>
                                </div>
                            </div>
                            <div class="bg-white px-3 sm:px-4 py-2 rounded-lg border border-blue-300">
                                <span class="text-xs sm:text-sm text-blue-700 font-medium">Paušal</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-500 italic">Nema materijala ni usluga u ovoj sekciji</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="border-t-2 border-gray-300 pt-4 sm:pt-6 space-y-3 sm:space-y-4">
                <div class="flex justify-between items-center gap-2">
                    <span class="text-sm sm:text-lg font-semibold text-gray-700">Ukupno Materijal:</span>
                    <span class="text-sm sm:text-lg font-bold text-gray-900 whitespace-nowrap">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                </div>
                
                @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                <div class="flex justify-between items-center gap-2">
                    <span class="text-xs sm:text-lg font-semibold text-gray-700">
                        Cena po satu: {{ number_format($workOrder->hourly_rate, 2) }} RSD &times; {{ number_format($workOrder->calculateTotalHours(), 2) }}h
                    </span>
                    <span class="text-sm sm:text-lg font-bold text-gray-900 whitespace-nowrap">{{ number_format($workOrder->calculateLaborCost(), 2) }} RSD</span>
                </div>
                
                <div class="border-t border-gray-300 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-base sm:text-xl font-semibold text-gray-700">Ukupan Iznos:</span>
                        <span class="text-xl sm:text-4xl font-bold text-primary-600 whitespace-nowrap">{{ number_format($workOrder->calculateGrandTotal(), 2) }} RSD</span>
                    </div>
                </div>
                @else
                <div class="border-t border-gray-300 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-base sm:text-xl font-semibold text-gray-700">Ukupan Iznos:</span>
                        <span class="text-xl sm:text-4xl font-bold text-primary-600 whitespace-nowrap">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Nazad
                </a>

                @if (!$workOrder->has_invoice)
                <form action="{{ route('worker.work-orders.invoice.generate', $workOrder) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="invoice_type" value="{{ $workOrder->client_type }}">
                    <input type="hidden" name="invoice_company_name" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_name : $workOrder->client_name }}">
                    <input type="hidden" name="invoice_pib" value="{{ $workOrder->pib ?? '' }}">
                    <input type="hidden" name="invoice_address" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_address : $workOrder->client_address }}">
                    <input type="hidden" name="invoice_email" value="{{ $workOrder->client_email ?? '' }}">
                    <input type="hidden" name="invoice_phone" value="{{ $workOrder->client_phone ?? '' }}">
                    <button type="submit" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generiši Fakturu
                    </button>
                </form>
                @else
                <a href="{{ route('worker.work-orders.invoice', $workOrder) }}" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Pregled Fakture
                </a>
                <form action="{{ route('worker.work-orders.invoice.generate', $workOrder) }}" method="POST" class="inline regenerate-invoice-form">
                    @csrf
                    <input type="hidden" name="invoice_type" value="{{ $workOrder->client_type }}">
                    <input type="hidden" name="invoice_company_name" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_name : $workOrder->client_name }}">
                    <input type="hidden" name="invoice_pib" value="{{ $workOrder->pib ?? '' }}">
                    <input type="hidden" name="invoice_address" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_address : $workOrder->client_address }}">
                    <input type="hidden" name="invoice_email" value="{{ $workOrder->client_email ?? '' }}">
                    <input type="hidden" name="invoice_phone" value="{{ $workOrder->client_phone ?? '' }}">
                    <button type="button" class="regenerate-invoice-btn btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Regeneriši Fakturu
                    </button>
                </form>
                @endif

                <form action="{{ route('worker.work-orders.destroy', $workOrder) }}" method="POST" class="sm:ml-auto delete-work-order-form" data-work-order-client="{{ $workOrder->client_name }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="delete-work-order-btn inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Obriši
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Delete work order confirmation with SweetAlert2
const deleteBtn = document.querySelector('.delete-work-order-btn');
if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-work-order-form');
        const clientName = form.dataset.workOrderClient;
        
        Swal.fire({
            title: 'Da li ste sigurni?',
            html: `<p class="text-gray-600 mt-2">Želite da obrišete radni nalog za klijenta <strong class="text-gray-900">"${clientName}"</strong>?</p><p class="text-red-600 text-sm mt-2">Ova akcija je nepovratna!</p>`,
            icon: 'warning',
            iconColor: '#3b82f6',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: '<span class="px-2">Da, obriši!</span>',
            cancelButtonText: '<span class="px-2">Otkaži</span>',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                title: 'text-2xl font-bold text-gray-900',
                htmlContainer: 'text-base',
                confirmButton: 'rounded-lg px-6 py-3 font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5',
                cancelButton: 'rounded-lg px-6 py-3 font-semibold hover:bg-gray-300 transition-all duration-200',
                actions: 'gap-3',
                icon: 'border-4 border-blue-100'
            },
            buttonsStyling: true,
            backdrop: 'rgba(0, 0, 0, 0.4)',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}

// Regenerate invoice confirmation with SweetAlert2
const regenerateBtn = document.querySelector('.regenerate-invoice-btn');
if (regenerateBtn) {
    regenerateBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.regenerate-invoice-form');
        
        Swal.fire({
            title: 'Regenerisati fakturu?',
            html: '<p class="text-gray-600 mt-2">Ovo će ažurirati postojeću fakturu sa trenutnim podacima radnog naloga.</p><p class="text-amber-600 text-sm mt-2 font-semibold">Faktura će biti ažurirana novim stavkama, cenama i ukupnim iznosom.</p>',
            icon: 'question',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: '<span class="px-2">Da, regeneriši!</span>',
            cancelButtonText: '<span class="px-2">Otkaži</span>',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                title: 'text-2xl font-bold text-gray-900',
                htmlContainer: 'text-base',
                confirmButton: 'rounded-lg px-6 py-3 font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5',
                cancelButton: 'rounded-lg px-6 py-3 font-semibold hover:bg-gray-300 transition-all duration-200',
                actions: 'gap-3',
                icon: 'border-4 border-amber-100'
            },
            buttonsStyling: true,
            backdrop: 'rgba(0, 0, 0, 0.4)',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}
</script>
@endsection
