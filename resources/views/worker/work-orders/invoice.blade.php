@extends('layouts.worker')

@section('title', 'Faktura #' . $workOrder->invoice_number)

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
    $lineNumber = 0;
@endphp

@section('content')
<div class="p-3 sm:p-6 max-w-5xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1.5 text-xs sm:text-sm text-gray-500 overflow-x-auto">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition whitespace-nowrap">Radni Nalozi</a></li>
            <li><svg class="w-3.5 h-3.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li><a href="{{ route('worker.work-orders.show', $workOrder) }}" class="hover:text-primary-600 transition whitespace-nowrap">Nalog #{{ $workOrder->id }}</a></li>
            <li><svg class="w-3.5 h-3.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-semibold whitespace-nowrap">Faktura</li>
        </ol>
    </nav>

    {{-- Success / Error Alerts --}}
    @if(session('success'))
    <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg shadow-sm animate-fade-in alert-success">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 sm:mb-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg shadow-sm animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-red-800 font-medium text-sm">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    {{-- Main Invoice Card --}}
    <div class="bg-white rounded-2xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">

        {{-- ===== Header ===== --}}
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-7">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                {{-- Left: invoice number + meta --}}
                <div class="text-white">
                    <p class="text-xs sm:text-sm font-medium opacity-80 uppercase tracking-wider">Faktura</p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-0.5 tracking-tight">#{{ $workOrder->invoice_number }}</h1>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs sm:text-sm opacity-90">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $workOrder->created_at->format('d.m.Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $workOrder->location }}
                        </span>
                    </div>
                </div>

                {{-- Right: action buttons --}}
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('worker.work-orders.invoice.download', $workOrder) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white border border-white/30 px-4 py-2.5 rounded-lg font-semibold hover:bg-white/25 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF
                    </a>
                    @if(!$workOrder->efaktura_status || $workOrder->efaktura_status === 'error')
                    <form id="efaktura-form" method="POST" action="{{ route('worker.work-orders.invoice.send-efaktura', $workOrder) }}" class="inline">
                        @csrf
                        <button type="button" onclick="document.getElementById('efaktura-confirm-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-white text-primary-700 px-4 py-2.5 rounded-lg font-semibold hover:bg-gray-100 transition-all shadow-lg text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            eFaktura
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            {{-- eFaktura status badge inside header --}}
            @if($workOrder->efaktura_status)
            <div class="mt-4 pt-3 border-t border-white/20">
                <div class="flex flex-wrap items-center gap-2">
                    @if($workOrder->efaktura_status === 'sent')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-400/20 text-green-100 border border-green-400/30">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        eFaktura poslato
                    </span>
                    @if($workOrder->efaktura_sent_at)
                    <span class="text-xs text-white/70">{{ $workOrder->efaktura_sent_at->format('d.m.Y H:i') }}</span>
                    @endif
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-400/20 text-red-100 border border-red-400/30">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        eFaktura greška
                    </span>
                    @endif
                    @if($workOrder->efaktura_response)
                    <button onclick="document.getElementById('efaktura-response-modal').classList.remove('hidden')" class="text-xs text-white/70 hover:text-white underline underline-offset-2 transition-colors">
                        Prikaži odgovor
                    </button>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- ===== Body ===== --}}
        <div class="p-4 sm:p-8">

            {{-- Parties: Seller / Buyer --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-8">
                {{-- Seller --}}
                <div class="rounded-xl border border-gray-200 p-4 sm:p-5 bg-gray-50/50">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Izdavalac</h3>
                    </div>
                    <p class="text-base sm:text-lg font-bold text-gray-900">{{ $companyName ?? 'F-Therm d.o.o.' }}</p>
                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                        <p>{{ $companyAddress ?? '' }}</p>
                        @if($companyPib)<p>PIB: <span class="font-medium text-gray-800">{{ $companyPib }}</span></p>@endif
                        @if($companyMaticniBroj)<p>MB: <span class="font-medium text-gray-800">{{ $companyMaticniBroj }}</span></p>@endif
                        @if($companyPhone)<p>Tel: {{ $companyPhone }}</p>@endif
                        @if($companyEmail)<p>{{ $companyEmail }}</p>@endif
                        @if($companyBankAccount)<p class="pt-1 font-medium text-gray-800">{{ $companyBankAccount }}</p>@endif
                    </div>
                </div>

                {{-- Buyer --}}
                <div class="rounded-xl border-2 border-primary-200 p-4 sm:p-5 bg-primary-50/30">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kupac</h3>
                    </div>
                    @if($workOrder->client_type === 'pravno_lice')
                        <p class="text-base sm:text-lg font-bold text-gray-900">{{ $workOrder->company_name }}</p>
                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            @if($workOrder->company_address)<p>{{ $workOrder->company_address }}</p>@endif
                            @if($workOrder->pib)<p>PIB: <span class="font-medium text-gray-800">{{ $workOrder->pib }}</span></p>@endif
                            @if($workOrder->maticni_broj)<p>MB: <span class="font-medium text-gray-800">{{ $workOrder->maticni_broj }}</span></p>@endif
                        </div>
                    @else
                        <p class="text-base sm:text-lg font-bold text-gray-900">{{ $workOrder->client_name }}</p>
                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            @if($workOrder->client_address)<p>{{ $workOrder->client_address }}</p>@endif
                        </div>
                    @endif
                    @if($workOrder->invoice_phone || $workOrder->invoice_email)
                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                        @if($workOrder->invoice_phone)<p>Tel: {{ $workOrder->invoice_phone }}</p>@endif
                        @if($workOrder->invoice_email)<p>{{ $workOrder->invoice_email }}</p>@endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- Invoice meta grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8">
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center border border-gray-100">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Br. računa</p>
                    <p class="text-sm sm:text-base font-bold text-gray-900">{{ $workOrder->invoice_number }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center border border-gray-100">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Datum prometa</p>
                    <p class="text-sm sm:text-base font-bold text-gray-900">{{ $workOrder->created_at->format('d.m.Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center border border-gray-100">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mesto izdavanja</p>
                    <p class="text-sm sm:text-base font-bold text-gray-900">{{ $workOrder->location }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center border border-gray-100">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Valuta plaćanja</p>
                    <p class="text-sm sm:text-base font-bold text-gray-900">{{ $workOrder->created_at->copy()->addMonth()->format('d.m.Y') }}</p>
                </div>
            </div>

            {{-- ===== Line Items ===== --}}
            <div class="mb-8">
                <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Stavke
                </h2>

                @foreach ($workOrder->sections as $section)
                <div class="mb-5 last:mb-0">
                    {{-- Section heading --}}
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 gap-1.5">
                        <h3 class="text-sm sm:text-base font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary-500 flex-shrink-0"></span>
                            {{ $section->title }}
                        </h3>
                        @if($section->hours_spent)
                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 rounded-full text-xs font-semibold w-fit">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ number_format($section->hours_spent, 2) }}h
                        </span>
                        @endif
                    </div>

                    @if($section->items->count() > 0)
                    {{-- Items table --}}
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-3 sm:px-5 py-2.5 text-left text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider w-8">#</th>
                                    <th class="px-3 sm:px-5 py-2.5 text-left text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Naziv</th>
                                    <th class="px-3 sm:px-5 py-2.5 text-center text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Kol.</th>
                                    <th class="hidden sm:table-cell px-5 py-2.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Jed. cena</th>
                                    <th class="px-3 sm:px-5 py-2.5 text-right text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Iznos</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($section->items as $item)
                                @php $lineNumber++; @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 sm:px-5 py-3 text-xs text-gray-400 font-mono">{{ $lineNumber }}</td>
                                    <td class="px-3 sm:px-5 py-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $item->product->unit }}</p>
                                        <p class="sm:hidden text-xs text-gray-400 mt-0.5">{{ number_format($item->price_at_time, 2) }} RSD/{{ $item->product->unit }}</p>
                                    </td>
                                    <td class="px-3 sm:px-5 py-3 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 bg-gray-100 rounded-md text-sm font-semibold text-gray-700">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell px-5 py-3 text-right text-sm text-gray-600">{{ number_format($item->price_at_time, 2) }}</td>
                                    <td class="px-3 sm:px-5 py-3 text-right text-sm font-bold text-gray-900 whitespace-nowrap">{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @elseif($section->service_price && $section->service_price > 0)
                    {{-- Service price card --}}
                    @php $lineNumber++; @endphp
                    <div class="rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50/80 to-indigo-50/50 p-4 sm:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider">Paušalna usluga</p>
                                    <p class="text-lg sm:text-xl font-bold text-gray-900 mt-0.5">{{ number_format($section->service_price, 2) }} <span class="text-sm font-normal text-gray-500">RSD</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                    <div class="rounded-xl border border-dashed border-gray-300 p-4 text-center">
                        <p class="text-sm text-gray-400 italic">Nema stavki u ovoj sekciji</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- ===== Totals ===== --}}
            <div class="border-t border-gray-200 pt-6">
                <div class="w-full sm:w-[420px] sm:ml-auto space-y-2">
                    {{-- Subtotals --}}
                    @if($materialsTotal > 0)
                    <div class="flex justify-between items-center py-2 text-sm">
                        <span class="text-gray-500">Materijal</span>
                        <span class="font-semibold text-gray-700">{{ number_format($materialsTotal, 2) }} RSD</span>
                    </div>
                    @endif
                    @if($servicesTotal > 0)
                    <div class="flex justify-between items-center py-2 text-sm">
                        <span class="text-gray-500">Usluge rada</span>
                        <span class="font-semibold text-gray-700">{{ number_format($servicesTotal, 2) }} RSD</span>
                    </div>
                    @endif
                    @if($travelCost > 0)
                    <div class="flex justify-between items-center py-2 text-sm">
                        <span class="text-gray-500">Putni troškovi <span class="text-xs">({{ number_format($workOrder->km_to_destination, 0) }} km &times; {{ number_format($kmPrice, 2) }})</span></span>
                        <span class="font-semibold text-gray-700">{{ number_format($travelCost, 2) }} RSD</span>
                    </div>
                    @endif

                    {{-- Grand total --}}
                    <div class="mt-2 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl px-5 py-4 flex justify-between items-center">
                        <span class="text-sm sm:text-base font-bold text-white/90 uppercase tracking-wide">Ukupno</span>
                        <span class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">{{ number_format($grandTotal, 2) }} <span class="text-sm font-normal opacity-80">RSD</span></span>
                    </div>

                    {{-- Amount in words --}}
                    <div class="rounded-lg bg-gray-50 border border-gray-100 px-4 py-2.5 mt-2">
                        <p class="text-xs text-gray-500"><span class="font-semibold text-gray-600">Slovima:</span> {{ str_replace(' ', '', number_to_words_serbian($grandTotal)) }} dinara</p>
                    </div>
                </div>
            </div>

            {{-- ===== Legal Footer ===== --}}
            <div class="mt-8 pt-5 border-t border-gray-100 text-center space-y-0.5">
                <p class="text-[11px] text-gray-400">Izdavalac računa nije obveznik PDV-a</p>
                <p class="text-[11px] text-gray-400">Registrovano u Subotici &mdash; u slučaju spora nadležan je Privredni sud u Subotici</p>
            </div>

            {{-- ===== Bottom Actions ===== --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-100">
                <a href="{{ route('worker.work-orders.show', $workOrder) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Radni Nalog
                </a>
                <a href="{{ route('worker.invoices.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Sve Fakture
                </a>
            </div>
        </div>
    </div>
</div>

{{-- eFaktura Confirm Modal --}}
<div id="efaktura-confirm-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('efaktura-confirm-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden z-10">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-primary-100 mb-4">
                    <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Slanje na eFaktura</h3>
                <p class="text-sm text-gray-600 mb-1">Da li ste sigurni da želite da pošaljete fakturu <span class="font-semibold text-gray-900">{{ $workOrder->invoice_number }}</span> na eFaktura sistem?</p>
            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                <button onclick="document.getElementById('efaktura-confirm-modal').classList.add('hidden')" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                    Otkaži
                </button>
                <button onclick="document.getElementById('efaktura-confirm-modal').classList.add('hidden'); document.getElementById('efaktura-form').submit();" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                    Pošalji
                </button>
            </div>
        </div>
    </div>
</div>

{{-- eFaktura Response Modal --}}
@if($workOrder->efaktura_response)
<div id="efaktura-response-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('efaktura-response-modal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden z-10">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                eFaktura Odgovor
            </h3>
            <button onclick="document.getElementById('efaktura-response-modal').classList.add('hidden')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <pre class="bg-gray-900 text-green-400 p-4 rounded-xl text-xs sm:text-sm overflow-x-auto whitespace-pre-wrap font-mono leading-relaxed">{{ json_encode(json_decode($workOrder->efaktura_response), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?: $workOrder->efaktura_response }}</pre>
        </div>
        <div class="px-6 py-3 border-t border-gray-100 text-right">
            <button onclick="document.getElementById('efaktura-response-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                Zatvori
            </button>
        </div>
    </div>
    </div>
</div>
@endif
@endsection
