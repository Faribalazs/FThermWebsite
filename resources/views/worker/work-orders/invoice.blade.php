@extends('layouts.worker')

@section('title', 'Faktura')

@section('content')
<div class="p-3 sm:p-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-2 text-xs sm:text-sm text-gray-600 overflow-x-auto">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition whitespace-nowrap">Radni Nalozi</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li><a href="{{ route('worker.work-orders.show', $workOrder) }}" class="hover:text-primary-600 transition whitespace-nowrap">Pregled</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium whitespace-nowrap">Faktura</li>
        </ol>
    </nav>

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 sm:px-8 py-4 sm:py-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-0">
            <div class="text-white">
                <h1 class="text-xl sm:text-3xl font-bold">Faktura #{!! $workOrder->invoice_number !!}</h1>
                <p class="text-xs sm:text-sm opacity-90 mt-1">{{ $workOrder->created_at->format('d.m.Y') }}</p>
            </div>
            <a href="{{ route('worker.work-orders.invoice.download', $workOrder) }}" target="_blank" class="bg-white text-indigo-600 px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center gap-2 shadow-lg text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Preuzmi PDF
            </a>
        </div>

        <div class="p-4 sm:p-8">
            <!-- Company and Client Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-6 sm:mb-8 pb-6 sm:pb-8 border-b border-gray-200">
                <!-- Company Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Izdavalac
                    </h3>
                    <div class="text-gray-900">
                        <p class="font-bold text-base sm:text-lg">{{ $companyName ?? 'F-Therm d.o.o.' }}</p>
                        <p class="text-xs sm:text-sm mt-2">{{ $companyAddress ?? 'Industrijska 15, Beograd' }}</p>
                        <p class="text-xs sm:text-sm mt-2">PIB: {{ $companyPib ?? '123456789' }}</p>
                        <p class="text-xs sm:text-sm">Matični broj: {{ $companyMaticniBroj ?? '987654321' }}</p>
                        <p class="text-xs sm:text-sm mt-2">Telefon: {{ $companyPhone ?? '' }}</p>
                        <p class="text-xs sm:text-sm">Email: {{ $companyEmail ?? '' }}</p>
                    </div>
                </div>

                <!-- Client Info -->
                <div class="bg-light-50 p-4 rounded-lg">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Kupac
                    </h3>
                    <div class="text-gray-900">
                        @if($workOrder->client_type === 'pravno_lice')
                            <p class="font-bold text-base sm:text-lg">{{ $workOrder->company_name }}</p>
                            @if($workOrder->company_address)
                            <p class="text-xs sm:text-sm mt-2">Adresa: {{ $workOrder->company_address }}</p>
                            @endif
                            @if($workOrder->pib)
                            <p class="text-xs sm:text-sm">PIB: {{ $workOrder->pib }}</p>
                            @endif
                            @if($workOrder->maticni_broj)
                            <p class="text-xs sm:text-sm">Matični broj: {{ $workOrder->maticni_broj }}</p>
                            @endif
                            @if($workOrder->location)
                            <p class="text-xs sm:text-sm">Lokacija: {{ $workOrder->location }}</p>
                            @endif
                        @else
                            <p class="font-bold text-base sm:text-lg">{{ $workOrder->client_name }}</p>
                            @if($workOrder->client_address)
                            <p class="text-xs sm:text-sm mt-2">Adresa: {{ $workOrder->client_address }}</p>
                            @endif
                            @if($workOrder->location)
                            <p class="text-xs sm:text-sm">Lokacija: {{ $workOrder->location }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Invoice Info -->
            <div class="mb-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-lg border border-indigo-100">
                <h3 class="text-xs sm:text-sm font-bold text-gray-500 uppercase mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Podaci o Fakturi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <p class="text-gray-900 text-sm sm:text-base"><span class="font-semibold">Br. računa:</span> {{ $workOrder->invoice_number }}</p>
                    <p class="text-gray-900 text-sm sm:text-base"><span class="font-semibold">Valuta plaćanja:</span> {{ $workOrder->created_at->copy()->addMonth()->format('d/m/Y') }}</p>
                    <p class="text-gray-900 text-sm sm:text-base"><span class="font-semibold">Mesto i datum:</span> {{ $workOrder->location }}, {{ $workOrder->created_at->format('d/m/Y') }}</p>
                    <p class="text-gray-900 text-sm sm:text-base"><span class="font-semibold">Datum prometa:</span> {{ $workOrder->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="mb-6 sm:mb-8">
                <h3 class="text-xs sm:text-sm font-bold text-gray-500 uppercase mb-4">Stavke</h3>
                
                @foreach ($workOrder->sections as $section)
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 gap-2">
                        <h4 class="text-sm sm:text-md font-bold text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $section->title }}
                        </h4>
                        @if($section->hours_spent)
                        <div class="flex items-center gap-2 bg-blue-100 px-3 py-1 rounded-full w-fit">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-800 font-semibold text-xs sm:text-sm">{{ number_format($section->hours_spent, 2) }}h</span>
                        </div>
                        @endif
                    </div>

                    @if($section->items->count() > 0)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase">Proizvod</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-center text-xs font-bold text-gray-700 uppercase">Količina</th>
                                    <th class="hidden sm:table-cell px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Jed. Cena</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-right text-xs font-bold text-gray-700 uppercase">Ukupno</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($section->items as $item)
                                <tr>
                                    <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-900">
                                        <div class="font-medium">{{ $item->product->name }}</div>
                                        <span class="text-gray-500 text-xs">({{ $item->product->unit }})</span>
                                        <div class="sm:hidden text-gray-500 text-xs mt-1">{{ number_format($item->price_at_time, 2) }} RSD/{{ $item->product->unit }}</div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600 text-center font-medium">{{ $item->quantity }}</td>
                                    <td class="hidden sm:table-cell px-4 py-3 text-sm text-gray-600 text-right">{{ number_format($item->price_at_time, 2) }} RSD</td>
                                    <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-semibold text-gray-900 text-right whitespace-nowrap">{{ number_format($item->subtotal, 2) }} RSD</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            <div class="border-t-2 border-gray-300 pt-6 pb-6">
                <div class="w-full sm:w-[450px] ml-auto">
                    @php
                        $materialsTotal = 0;
                        foreach ($workOrder->sections as $section) {
                            foreach ($section->items as $item) {
                                $materialsTotal += $item->subtotal;
                            }
                        }
                        
                        $servicesTotal = 0;
                        foreach ($workOrder->sections as $section) {
                            if ($section->service_price && $section->service_price > 0) {
                                $servicesTotal += $section->service_price;
                            }
                        }
                        
                        $travelCost = 0;
                        if ($workOrder->km_to_destination && $kmPrice > 0) {
                            $travelCost = $workOrder->km_to_destination * $kmPrice;
                        }
                        
                        $grandTotal = $materialsTotal + $servicesTotal + $travelCost;
                    @endphp
                    
                    <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200 text-sm sm:text-base">
                        <span class="text-gray-600">Materijal:</span>
                        <span class="font-semibold">{{ number_format($materialsTotal, 2) }} RSD</span>
                    </div>
                    @if($servicesTotal > 0)
                    <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200 text-sm sm:text-base">
                        <span class="text-gray-600">Usluge rada:</span>
                        <span class="font-semibold">{{ number_format($servicesTotal, 2) }} RSD</span>
                    </div>
                    @endif
                    @if($travelCost > 0)
                    <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-200 text-sm sm:text-base">
                        <span class="text-gray-600">Putni troškovi ({{ number_format($workOrder->km_to_destination, 0) }} km × {{ number_format($kmPrice, 2) }} RSD):</span>
                        <span class="font-semibold">{{ number_format($travelCost, 2) }} RSD</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center py-3 sm:py-4 bg-gradient-to-r from-indigo-50 to-blue-50 px-3 sm:px-4 rounded-lg mt-3 border-2 border-indigo-200">
                        <span class="text-lg sm:text-xl font-bold text-gray-900">UKUPNO:</span>
                        <span class="text-xl sm:text-2xl font-bold text-indigo-600">{{ number_format($grandTotal, 2) }} RSD</span>
                    </div>
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs sm:text-sm text-gray-700 italic"><strong>Ukupan iznos slovima:</strong> {{ str_replace(' ', '', number_to_words_serbian($grandTotal)) }} dinara</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-xs sm:text-sm text-gray-500 mt-6 sm:mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs">Izdavalac računa nije obveznik pdv-a</p>
                <p class="text-xs mt-1">Registrovano u Subotici u slučaju spora nadležan je Privredni sud u Subotici</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col w-full justify-between sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="{{ route('worker.work-orders.show', $workOrder) }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Nazad na Radni Nalog
                </a>
                <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm sm:text-base">
                    Lista Naloga
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
