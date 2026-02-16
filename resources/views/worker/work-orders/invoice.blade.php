@extends('layouts.worker')

@section('title', 'Faktura')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li><a href="{{ route('worker.work-orders.show', $workOrder) }}" class="hover:text-primary-600 transition">Pregled</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Faktura</li>
        </ol>
    </nav>

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6 flex justify-between items-center">
            <div class="text-white">
                <h1 class="text-3xl font-bold">Faktura #{!! $workOrder->invoice_number !!}</h1>
                <p class="text-sm opacity-90 mt-1">{{ $workOrder->created_at->format('d.m.Y') }}</p>
            </div>
            <a href="{{ route('worker.work-orders.invoice.download', $workOrder) }}" target="_blank" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Preuzmi PDF
            </a>
        </div>

        <div class="p-8">
            <!-- Company and Client Info -->
            <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                <!-- Company Info -->
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Izdavalac</h3>
                    <div class="text-gray-900">
                        <p class="font-bold text-lg">F-Therm d.o.o.</p>
                        <p class="text-sm mt-2">Industrijska 15</p>
                        <p class="text-sm">Beograd, Srbija</p>
                        <p class="text-sm mt-2">PIB: 123456789</p>
                        <p class="text-sm">Matični broj: 987654321</p>
                    </div>
                </div>

                <!-- Client Info -->
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Kupac</h3>
                    <div class="text-gray-900">
                        <p class="font-bold text-lg">{{ $workOrder->invoice_company_name }}</p>
                        @if ($workOrder->invoice_pib)
                        <p class="text-sm mt-2">PIB: {{ $workOrder->invoice_pib }}</p>
                        @endif
                        <p class="text-sm {{ $workOrder->invoice_pib ? '' : 'mt-2' }}">{{ $workOrder->invoice_address }}</p>
                        @if ($workOrder->invoice_email)
                        <p class="text-sm mt-2">Email: {{ $workOrder->invoice_email }}</p>
                        @endif
                        @if ($workOrder->invoice_phone)
                        <p class="text-sm">Tel: {{ $workOrder->invoice_phone }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Work Order Info -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-2">Radni Nalog</h3>
                <p class="text-gray-900"><span class="font-semibold">Klijent:</span> {{ $workOrder->client_name }}</p>
                <p class="text-gray-900"><span class="font-semibold">Lokacija:</span> {{ $workOrder->location }}</p>
            </div>

            <!-- Items Table -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-4">Stavke</h3>
                
                @foreach ($workOrder->sections as $section)
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-md font-bold text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $section->title }}
                        </h4>
                        @if($section->hours_spent)
                        <div class="flex items-center gap-2 bg-blue-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-800 font-semibold text-sm">{{ number_format($section->hours_spent, 2) }}h</span>
                        </div>
                        @endif
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Proizvod</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Količina</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Jed. Cena</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Ukupno</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($section->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->product->name }}
                                        <span class="text-gray-500 text-xs">({{ $item->product->unit }})</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 text-right">{{ number_format($item->price_at_time, 2) }} RSD</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">{{ number_format($item->subtotal, 2) }} RSD</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="border-t-2 border-gray-300 pt-6 pb-6 flex justify-end">
                <div class="w-80">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Materijal:</span>
                        <span class="font-semibold">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                    </div>
                    @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Rad ({{ number_format($workOrder->calculateTotalHours(), 2) }}h × {{ number_format($workOrder->hourly_rate, 2) }} RSD):</span>
                        <span class="font-semibold">{{ number_format($workOrder->calculateLaborCost(), 2) }} RSD</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Osnova:</span>
                        <span class="font-semibold">{{ number_format($workOrder->calculateGrandTotal() / 1.2, 2) }} RSD</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">PDV (20%):</span>
                        <span class="font-semibold">{{ number_format($workOrder->calculateGrandTotal() - ($workOrder->calculateGrandTotal() / 1.2), 2) }} RSD</span>
                    </div>
                    <div class="flex justify-between items-center py-4 bg-indigo-50 px-4 rounded-lg mt-3">
                        <span class="text-xl font-bold text-gray-900">UKUPNO:</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ number_format($workOrder->calculateGrandTotal(), 2) }} RSD</span>
                    </div>
                    @else
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Osnova:</span>
                        <span class="font-semibold">{{ number_format($workOrder->total_amount / 1.2, 2) }} RSD</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">PDV (20%):</span>
                        <span class="font-semibold">{{ number_format($workOrder->total_amount - ($workOrder->total_amount / 1.2), 2) }} RSD</span>
                    </div>
                    <div class="flex justify-between items-center py-4 bg-indigo-50 px-4 rounded-lg mt-3">
                        <span class="text-xl font-bold text-gray-900">UKUPNO:</span>
                        <span class="text-2xl font-bold text-indigo-600">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-sm text-gray-500 mt-8 pt-6 border-t border-gray-200">
                <p>Hvala Vam na poverenju!</p>
                <p class="mt-1">Za sva pitanja kontaktirajte nas na: info@ftherm.rs | +381 11 123 4567</p>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 mt-8">
                <a href="{{ route('worker.work-orders.show', $workOrder) }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Nazad na Radni Nalog
                </a>
                <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Lista Naloga
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
