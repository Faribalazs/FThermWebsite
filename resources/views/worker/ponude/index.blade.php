@extends('layouts.worker')

@section('title', 'Ponude')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-6 animate-fade-in">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-2 sm:gap-3">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Ponude
                </h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Kreirajte i upravljajte ponudama za klijente</p>
            </div>
            <a href="{{ route('worker.ponude.create') }}" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Ponuda
            </a>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-3 sm:p-6 mb-4 sm:mb-6 animate-slide-in">
            <form method="GET" action="{{ route('worker.ponude.index') }}" class="space-y-4">
                <!-- Search -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Pretraga</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Pretražite po klijentu ili lokaciji..."
                               class="form-input w-full pl-9 sm:pl-10 pr-3 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- Filters Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <x-custom-select
                        name="location"
                        id="location_filter"
                        :selected="request('location')"
                        :selectedText="request('location') ?: ''"
                        :options="collect(['' => 'Sve lokacije'])->merge($locations->mapWithKeys(fn($loc) => [$loc => $loc]))->toArray()"
                        label="Lokacija"
                    />

                    <x-custom-datepicker
                        name="date_from"
                        id="ponuda_date_from"
                        :value="request('date_from', '')"
                        label="Datum od"
                        placeholder="Izaberite datum"
                    />

                    <x-custom-datepicker
                        name="date_to"
                        id="ponuda_date_to"
                        :value="request('date_to', '')"
                        label="Datum do"
                        placeholder="Izaberite datum"
                    />

                    <x-custom-select
                        name="sort_by"
                        id="sort_by_filter"
                        :selected="request('sort_by', 'created_at')"
                        :selectedText="[
                            'created_at' => 'Datumu',
                            'client_name' => 'Klijentu',
                            'total_amount' => 'Iznosu',
                            'location' => 'Lokaciji'
                        ][request('sort_by', 'created_at')] ?? 'Datumu'"
                        :options="[
                            'created_at' => 'Datumu',
                            'client_name' => 'Klijentu',
                            'total_amount' => 'Iznosu',
                            'location' => 'Lokaciji'
                        ]"
                        label="Sortiraj po"
                    />
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Primeni Filtere
                    </button>
                    <a href="{{ route('worker.ponude.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
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
                        {{ request('sort_order') == 'asc' ? 'Rastuće' : 'Opadajuće' }}
                    </button>
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg shadow-sm animate-fade-in alert-success">
            <div class="flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-500 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm sm:text-base">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Ponude Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="ponude-grid">
        @forelse($ponude as $i => $p)
        <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 card-hover animate-scale-in ponuda-card" data-index="{{ $i }}">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 p-4">
                <div class="flex justify-between items-start">
                    <div class="text-white">
                        <p class="text-sm opacity-90">Klijent</p>
                        <h3 class="text-lg font-bold mt-1">
                            @if($p->client_type === 'pravno_lice')
                                {{ $p->company_name }}
                            @else
                                {{ $p->client_name }}
                            @endif
                        </h3>
                    </div>
                    <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap">
                        #{{ $p->id }}
                    </span>
                </div>
            </div>

            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">{{ $p->location }}</span>
                    </div>

                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm">{{ $p->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span class="text-sm">{{ $p->sections->count() }} {{ $p->sections->count() === 1 ? 'usluga' : 'usluge/usluga' }}</span>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Ukupno:</span>
                            <span class="text-2xl font-bold text-primary-600">{{ number_format($p->total_amount, 2) }} RSD</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('worker.ponude.show', $p) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-all action-btn text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Pregled
                    </a>
                    <a href="{{ route('worker.ponude.export-pdf', $p) }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-all action-btn text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-12 text-center empty-state animate-fade-in">
                <svg class="w-16 h-16 sm:w-24 sm:h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <p class="text-gray-500 text-base sm:text-lg font-medium">
                    {{ request()->hasAny(['search','location','date_from','date_to']) ? 'Nema ponuda koje zadovoljavaju kriterijume pretrage.' : 'Nema kreiranih ponuda' }}
                </p>
                @if(!request()->hasAny(['search','location','date_from','date_to']))
                <p class="text-gray-400 text-xs sm:text-sm mt-1">Kreirajte prvu ponudu klikom na dugme iznad</p>
                @endif
            </div>
        </div>
        @endforelse
        </div>

        <!-- Show All / Show Less Button -->
        @if($ponude->count() > 4)
        <div class="mt-4 sm:mt-6 text-center" id="show-all-container">
            <button onclick="toggleAllPonude()" id="show-all-btn"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-all">
                <svg id="show-all-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span id="show-all-label">Prikaži sve ({{ $ponude->count() }})</span>
            </button>
        </div>
        @endif

        <!-- Pagination -->
        @if($ponude->hasPages())
        <div class="mt-6 sm:mt-8">
            {{ $ponude->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const TOTAL_PONUDE = {{ $ponude->count() }};
    let allPonudeVisible = false;

    function getLimit() {
        return window.innerWidth >= 768 ? 6 : 4;
    }

    function applyLimit() {
        if (allPonudeVisible) return;
        const limit = getLimit();
        document.querySelectorAll('.ponuda-card').forEach(el => {
            const idx = parseInt(el.dataset.index);
            el.classList.toggle('hidden', idx >= limit);
        });
        const container = document.getElementById('show-all-container');
        if (container) container.classList.toggle('hidden', TOTAL_PONUDE <= limit);
    }

    function toggleAllPonude() {
        allPonudeVisible = !allPonudeVisible;
        const limit = getLimit();
        document.querySelectorAll('.ponuda-card').forEach(el => {
            const idx = parseInt(el.dataset.index);
            el.classList.toggle('hidden', !allPonudeVisible && idx >= limit);
        });
        const label = document.getElementById('show-all-label');
        const icon  = document.getElementById('show-all-icon');
        label.textContent = allPonudeVisible ? 'Prikaži manje' : 'Prikaži sve (' + TOTAL_PONUDE + ')';
        icon.style.transform = allPonudeVisible ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    applyLimit();
    window.addEventListener('resize', () => {
        if (!allPonudeVisible) applyLimit();
    });
</script>
@endpush
@endsection
