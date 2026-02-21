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
        <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg shadow-sm animate-fade-in alert-success">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 sm:mb-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 font-medium text-sm">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Work Order Card -->
    <div class="bg-white rounded-2xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-6">
            <div class="flex flex-col gap-4">
                <!-- Client Name & Location -->
                <div class="text-white">
                    <p class="text-xs opacity-80 uppercase tracking-wider font-medium">Radni Nalog</p>
                    <h1 class="text-xl sm:text-3xl font-bold mt-1">
                        @if($workOrder->client_type === 'pravno_lice')
                            {{ $workOrder->company_name }}
                        @else
                            {{ $workOrder->client_name }}
                        @endif
                    </h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="flex items-center gap-1.5 text-sm opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $workOrder->location }}
                        </span>
                        @if($workOrder->km_to_destination)
                        <span class="flex items-center gap-1.5 text-sm opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ number_format($workOrder->km_to_destination, 2) }} km
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Status Badge + Invoice Badge -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide
                        {{ $workOrder->status == 'completed' ? 'bg-green-500/20 text-green-100 ring-1 ring-green-400/30' : 'bg-yellow-500/20 text-yellow-100 ring-1 ring-yellow-400/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $workOrder->status == 'completed' ? 'bg-green-300' : 'bg-yellow-300' }}"></span>
                        {{ $workOrder->status == 'completed' ? 'Završen' : 'U toku' }}
                    </span>
                    @if ($workOrder->has_invoice)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-500/20 text-green-100 ring-1 ring-green-400/30">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Fakturisano
                    </span>
                    @endif
                </div>

                <!-- Quick Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('worker.work-orders.edit', $workOrder) }}" class="inline-flex items-center gap-1.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm text-white font-semibold px-4 py-2.5 rounded-xl transition-all text-sm ring-1 ring-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Uredi
                    </a>
                    <a href="{{ route('worker.work-orders.export-pdf', $workOrder) }}" class="inline-flex items-center gap-1.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm text-white font-semibold px-4 py-2.5 rounded-xl transition-all text-sm ring-1 ring-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-4 sm:p-8">
            <!-- Client Information Card -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-4 sm:p-6 mb-5 sm:mb-6">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($workOrder->client_type === 'pravno_lice')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            @endif
                        </svg>
                    </div>
                    Informacije o Klijentu
                    <span class="text-xs font-semibold bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full ml-auto">
                        {{ $workOrder->client_type === 'pravno_lice' ? 'Pravno Lice' : 'Fizičko Lice' }}
                    </span>
                </h3>
                <div class="grid sm:grid-cols-2 grid-cols-1 gap-3 sm:gap-4">
                    @if($workOrder->client_type === 'pravno_lice')
                        @if($workOrder->company_name)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Naziv Kompanije</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->company_name }}</p>
                        </div>
                        @endif
                        @if($workOrder->pib)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">PIB</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->pib }}</p>
                        </div>
                        @endif
                        @if($workOrder->maticni_broj)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Matični Broj</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->maticni_broj }}</p>
                        </div>
                        @endif
                        @if($workOrder->company_address)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Adresa</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->company_address }}</p>
                        </div>
                        @endif
                    @else
                        @if($workOrder->client_name)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Ime i Prezime</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->client_name }}</p>
                        </div>
                        @endif
                        @if($workOrder->client_address)
                        <div class="bg-white rounded-xl p-3 border border-blue-100">
                            <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Adresa</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $workOrder->client_address }}</p>
                        </div>
                        @endif
                    @endif
                    @if($workOrder->client_phone)
                    <div class="bg-white rounded-xl p-3 border border-blue-100">
                        <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telefon
                        </p>
                        <p class="text-sm font-semibold text-gray-900">{{ $workOrder->client_phone }}</p>
                    </div>
                    @endif
                    @if($workOrder->client_email)
                    <div class="bg-white rounded-xl p-3 border border-blue-100">
                        <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email
                        </p>
                        <p class="text-sm font-semibold text-gray-900 break-all">{{ $workOrder->client_email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Date & Status Row -->
            <div class="flex items-center gap-3 mb-5 sm:mb-6">
                <div class="flex-1 bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100">
                    <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Datum</p>
                    <p class="text-sm sm:text-base font-bold text-gray-900">{{ $workOrder->created_at->format('d.m.Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $workOrder->created_at->format('H:i') }}</p>
                </div>
                <div class="flex-1 bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100">
                    <p class="text-[11px] text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Status</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                        {{ $workOrder->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $workOrder->status == 'completed' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                        {{ $workOrder->status == 'completed' ? 'Završen' : 'U toku' }}
                    </span>
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-4 sm:space-y-6 mb-5 sm:mb-8">
                @foreach ($workOrder->sections as $section)
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                    <!-- Section Header -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                {{ $section->title }}
                            </h2>
                            @if($section->hours_spent)
                            <div class="flex items-center gap-1.5 bg-blue-100 px-2.5 py-1 rounded-full">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-blue-800 font-bold text-xs">{{ number_format($section->hours_spent, 2) }}h</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($section->items->count() > 0)
                    <!-- Mobile Card Layout -->
                    <div class="sm:hidden divide-y divide-gray-100">
                        @foreach ($section->items as $item)
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->product->unit }}</p>
                                </div>
                                <p class="text-sm font-bold text-primary-700 whitespace-nowrap">{{ number_format($item->subtotal, 2) }} <span class="text-xs font-semibold">RSD</span></p>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>J. cena: <span class="font-semibold text-gray-700">{{ number_format($item->price_at_time, 2) }}</span></span>
                                <span>&times;</span>
                                <span>Kol: <span class="font-semibold text-gray-700">{{ $item->quantity }}</span></span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden sm:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Proizvod</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">J. Cena</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kol.</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Ukupno</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($section->items as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                        {{ $item->product->name }}
                                        <span class="text-gray-400 text-xs">({{ $item->product->unit }})</span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-600">{{ number_format($item->price_at_time, 2) }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-6 py-3 text-sm font-bold text-gray-900 text-right">{{ number_format($item->subtotal, 2) }} RSD</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif($section->service_price && $section->service_price > 0)
                    <div class="p-4 sm:p-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 sm:p-6 border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-500 text-white rounded-xl p-2.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-600 font-semibold">Cena usluge</p>
                                        <p class="text-lg sm:text-2xl font-bold text-blue-900">{{ number_format($section->service_price, 2) }} RSD</p>
                                    </div>
                                </div>
                                <span class="bg-white px-3 py-1.5 rounded-lg border border-blue-200 text-xs text-blue-700 font-semibold">Paušal</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="p-4 sm:p-6">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-sm text-gray-500 italic">Nema materijala ni usluga u ovoj sekciji</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Total Summary -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 p-4 sm:p-6 mb-5 sm:mb-8">
                <div class="space-y-3">
                    @if($workOrder->calculateMaterialTotal() > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Ukupno Materijal</span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($workOrder->calculateMaterialTotal(), 2) }} RSD</span>
                    </div>
                    @endif

                    @if($workOrder->calculateServiceTotal() > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Ukupno Usluge</span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($workOrder->calculateServiceTotal(), 2) }} RSD</span>
                    </div>
                    @endif

                    @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">
                            Rad ({{ number_format($workOrder->hourly_rate, 2) }} &times; {{ number_format($workOrder->calculateTotalHours(), 2) }}h)
                        </span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($workOrder->calculateLaborCost(), 2) }} RSD</span>
                    </div>
                    @endif

                    <!-- Grand Total -->
                    <div class="border-t-2 border-gray-300 pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-base sm:text-lg font-bold text-gray-800">Ukupan Iznos</span>
                            <span class="text-xl sm:text-3xl font-extrabold text-primary-600">{{ number_format($workOrder->calculateGrandTotal(), 2) }} <span class="text-sm sm:text-base font-bold">RSD</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 sm:space-y-0 sm:flex sm:flex-wrap sm:gap-3">
                <!-- Primary Actions -->
                @if (!$workOrder->has_invoice)
                <form action="{{ route('worker.work-orders.invoice.generate', $workOrder) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="invoice_type" value="{{ $workOrder->client_type }}">
                    <input type="hidden" name="invoice_company_name" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_name : $workOrder->client_name }}">
                    <input type="hidden" name="invoice_pib" value="{{ $workOrder->pib ?? '' }}">
                    <input type="hidden" name="invoice_address" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_address : $workOrder->client_address }}">
                    <input type="hidden" name="invoice_email" value="{{ $workOrder->client_email ?? '' }}">
                    <input type="hidden" name="invoice_phone" value="{{ $workOrder->client_phone ?? '' }}">
                    <button type="submit" class="btn-gradient w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-5 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generiši Fakturu
                    </button>
                </form>
                @else
                <a href="{{ route('worker.work-orders.invoice', $workOrder) }}" class="btn-gradient w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white font-semibold px-5 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Pregled Fakture
                </a>
                <form action="{{ route('worker.work-orders.invoice.generate', $workOrder) }}" method="POST" class="w-full sm:w-auto inline regenerate-invoice-form">
                    @csrf
                    <input type="hidden" name="invoice_type" value="{{ $workOrder->client_type }}">
                    <input type="hidden" name="invoice_company_name" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_name : $workOrder->client_name }}">
                    <input type="hidden" name="invoice_pib" value="{{ $workOrder->pib ?? '' }}">
                    <input type="hidden" name="invoice_address" value="{{ $workOrder->client_type === 'pravno_lice' ? $workOrder->company_address : $workOrder->client_address }}">
                    <input type="hidden" name="invoice_email" value="{{ $workOrder->client_email ?? '' }}">
                    <input type="hidden" name="invoice_phone" value="{{ $workOrder->client_phone ?? '' }}">
                    <button type="button" class="regenerate-invoice-btn btn-gradient w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold px-5 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Regeneriši Fakturu
                    </button>
                </form>
                @endif

                <!-- Secondary Actions -->
                <div class="flex gap-3 sm:ml-auto">
                    <a href="{{ route('worker.work-orders.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Nazad
                    </a>
                    <form action="{{ route('worker.work-orders.destroy', $workOrder) }}" method="POST" class="flex-1 sm:flex-none delete-work-order-form" data-work-order-client="{{ $workOrder->client_name }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-work-order-btn w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors font-medium text-sm ring-1 ring-red-200">
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
