@extends('layouts.worker')

@section('title', 'Pregled Ponude')

@section('content')
<div class="p-3 sm:p-6 max-w-5xl mx-auto">
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.ponude.index') }}" class="hover:text-primary-600 transition">Ponude</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Pregled</li>
        </ol>
    </nav>

    @if(session('success'))
    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <div class="text-white flex-1">
                    <p class="text-xs sm:text-sm opacity-90">Ponuda #{{ $ponuda->id }}</p>
                    <h1 class="text-xl sm:text-3xl font-bold mt-1">
                        @if($ponuda->client_type === 'pravno_lice')
                            {{ $ponuda->company_name }}
                        @else
                            {{ $ponuda->client_name }}
                        @endif
                    </h1>
                    <p class="text-xs sm:text-sm opacity-90 mt-1 sm:mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $ponuda->location }}
                    </p>
                    @if($ponuda->km_to_destination)
                    <p class="text-xs sm:text-sm opacity-90 mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        {{ number_format($ponuda->km_to_destination, 2) }} km
                    </p>
                    @endif
                </div>
                <div class="grid grid-cols-3 sm:flex sm:flex-row gap-2 mt-2 sm:mt-0">
                    <a href="{{ route('worker.ponude.edit', $ponuda) }}"
                        class="inline-flex items-center justify-center gap-1.5 bg-white text-blue-700 font-semibold px-3 sm:px-4 py-2.5 sm:py-2 rounded-lg shadow-lg hover:shadow-xl transition-all text-xs sm:text-sm border border-blue-200 hover:bg-blue-50">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Uredi
                    </a>
                    <a href="{{ route('worker.ponude.export-pdf', $ponuda) }}" target="_blank"
                        class="inline-flex items-center justify-center gap-1.5 bg-white text-primary-700 font-semibold px-3 sm:px-4 py-2.5 sm:py-2 rounded-lg shadow-lg hover:shadow-xl transition-all text-xs sm:text-sm border border-primary-200 hover:bg-primary-50">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF
                    </a>
                    <form method="POST" action="{{ route('worker.ponude.destroy', $ponuda) }}"
                        onsubmit="return confirm('Obrisati ovu ponudu?')" class="contents">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-1.5 bg-white text-red-600 font-semibold px-3 sm:px-4 py-2.5 sm:py-2 rounded-lg shadow-lg hover:shadow-xl transition-all text-xs sm:text-sm border border-red-200 hover:bg-red-50">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Obriši
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-3 sm:p-8">
            <!-- Client info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informacije o klijentu
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    @if($ponuda->client_type === 'pravno_lice')
                        @if($ponuda->company_name)<div><p class="text-gray-500 text-xs mb-0.5">Naziv firme</p><p class="font-semibold text-gray-900">{{ $ponuda->company_name }}</p></div>@endif
                        @if($ponuda->pib)<div><p class="text-gray-500 text-xs mb-0.5">PIB</p><p class="font-semibold text-gray-900">{{ $ponuda->pib }}</p></div>@endif
                        @if($ponuda->maticni_broj)<div><p class="text-gray-500 text-xs mb-0.5">Matični broj</p><p class="font-semibold text-gray-900">{{ $ponuda->maticni_broj }}</p></div>@endif
                        @if($ponuda->company_address)<div><p class="text-gray-500 text-xs mb-0.5">Adresa firme</p><p class="font-semibold text-gray-900">{{ $ponuda->company_address }}</p></div>@endif
                    @else
                        @if($ponuda->client_name)<div><p class="text-gray-500 text-xs mb-0.5">Ime i Prezime</p><p class="font-semibold text-gray-900">{{ $ponuda->client_name }}</p></div>@endif
                        @if($ponuda->client_address)<div><p class="text-gray-500 text-xs mb-0.5">Adresa</p><p class="font-semibold text-gray-900">{{ $ponuda->client_address }}</p></div>@endif
                    @endif
                    @if($ponuda->client_phone)<div><p class="text-gray-500 text-xs mb-0.5">Telefon</p><p class="font-semibold text-gray-900">{{ $ponuda->client_phone }}</p></div>@endif
                    @if($ponuda->client_email)<div><p class="text-gray-500 text-xs mb-0.5">Email</p><p class="font-semibold text-gray-900">{{ $ponuda->client_email }}</p></div>@endif
                </div>
            </div>

            <!-- Notes -->
            @if($ponuda->notes)
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 sm:p-6 mb-6">
                <h3 class="text-base font-bold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    Napomena
                </h3>
                <p class="text-sm text-gray-700">{{ $ponuda->notes }}</p>
            </div>
            @endif

            <!-- Sections -->
            <div class="space-y-6">
                @foreach($ponuda->sections as $section)
                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-4">
                        <h4 class="text-lg font-bold text-gray-900">{{ $section->title }}</h4>
                        <div class="flex flex-wrap gap-3 text-sm">
                            @if($section->hours_spent)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $section->hours_spent }} sati
                                @if($ponuda->hourly_rate)
                                    ({{ number_format($section->hours_spent * $ponuda->hourly_rate, 2) }} RSD)
                                @endif
                            </span>
                            @endif
                            @if($section->service_price)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                Usluga: {{ number_format($section->service_price, 2) }} RSD
                            </span>
                            @endif
                        </div>
                    </div>

                    @if($section->items->count() > 0)
                    {{-- Mobile card list --}}
                    <div class="md:hidden space-y-2">
                        @foreach($section->items as $item)
                        <div class="bg-white rounded-lg border border-gray-200 p-3">
                            <p class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</p>
                            <div class="mt-1.5 flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $item->quantity }} {{ $item->product->unit }} &times; {{ number_format($item->price_at_time, 2) }} RSD</span>
                                <span class="text-sm font-bold text-primary-700">{{ number_format($item->price_at_time * $item->quantity, 2) }} RSD</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- Desktop table --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-300 text-left">
                                    <th class="pb-2 font-semibold text-gray-700">Materijal</th>
                                    <th class="pb-2 font-semibold text-gray-700 text-right">Cena/kom</th>
                                    <th class="pb-2 font-semibold text-gray-700 text-center">Količina</th>
                                    <th class="pb-2 font-semibold text-gray-700 text-right">Ukupno</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($section->items as $item)
                                <tr>
                                    <td class="py-2 font-medium text-gray-900">{{ $item->product->name }}</td>
                                    <td class="py-2 text-right text-gray-700">{{ number_format($item->price_at_time, 2) }} RSD</td>
                                    <td class="py-2 text-center text-gray-700">{{ $item->quantity }} {{ $item->product->unit }}</td>
                                    <td class="py-2 text-right font-semibold text-gray-900">{{ number_format($item->price_at_time * $item->quantity, 2) }} RSD</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="mt-6 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-4 sm:p-6 text-white">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                    <div>
                        <p class="text-primary-100 text-xs sm:text-sm">Ukupna vrednost ponude</p>
                        <p class="text-2xl sm:text-3xl font-bold mt-1 break-all">{{ number_format($ponuda->total_amount, 2) }} RSD</p>
                    </div>
                    <div class="flex sm:flex-col gap-4 sm:gap-0 sm:text-right">
                        <div class="text-primary-100 text-xs sm:text-sm">
                            <p>Datum kreiranja</p>
                            <p class="font-semibold text-white">{{ $ponuda->created_at->format('d.m.Y') }}</p>
                        </div>
                        @if($ponuda->hourly_rate)
                        <div class="text-primary-100 text-xs sm:text-sm sm:mt-2">
                            <p>Cena rada</p>
                            <p class="font-semibold text-white">{{ number_format($ponuda->hourly_rate, 2) }} RSD/h</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
