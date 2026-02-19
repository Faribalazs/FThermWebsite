@extends('layouts.worker')

@section('title', 'Dnevnik Aktivnosti')

@section('content')
<div class="p-3 sm:p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-6 animate-fade-in">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dnevnik Aktivnosti</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Pregled svih aktivnosti u sistemu</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 sm:p-6 mb-6">
            <form method="GET" action="{{ route('worker.activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                <!-- User Filter -->
                <x-custom-select
                    name="user_id"
                    id="user_filter"
                    :selected="request('user_id')"
                    :selectedText="request('user_id') ? $users->firstWhere('id', request('user_id'))?->name : ''"
                    :options="collect(['' => 'Svi korisnici'])->merge($users->pluck('name', 'id'))->toArray()"
                    label="Korisnik"
                />

                <!-- Action Type Filter -->
                <x-custom-select
                    name="action_type"
                    id="action_type_filter"
                    :selected="request('action_type')"
                    :selectedText="request('action_type') ? $actionTypes[request('action_type')] : ''"
                    :options="array_merge(['' => 'Sve akcije'], $actionTypes)"
                    label="Tip akcije"
                />

                <!-- Entity Type Filter -->
                <x-custom-select
                    name="entity_type"
                    id="entity_type_filter"
                    :selected="request('entity_type')"
                    :selectedText="request('entity_type') ? $entityTypes[request('entity_type')] : ''"
                    :options="array_merge(['' => 'Svi entiteti'], $entityTypes)"
                    label="Tip entiteta"
                />

                <!-- Date From -->
                <x-custom-datepicker
                    name="date_from"
                    id="date_from"
                    :value="request('date_from', '')"
                    label="Od datuma"
                    placeholder="Izaberite datum"
                />

                <!-- Date To -->
                <x-custom-datepicker
                    name="date_to"
                    id="date_to"
                    :value="request('date_to', '')"
                    label="Do datuma"
                    placeholder="Izaberite datum"
                />

                <!-- Action Buttons -->
                <div class="sm:col-span-2 lg:col-span-5 flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-primary-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-primary-700 transition">
                        <svg class="inline w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filtriraj
                    </button>
                    <a href="{{ route('worker.activity-logs.index') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-gray-200 text-gray-700 text-sm sm:text-base font-semibold rounded-lg hover:bg-gray-300 transition text-center">
                        Poništi filtere
                    </a>
                </div>
            </form>
        </div>

        <!-- Per Page Selector -->
        <div class="flex justify-end mb-4">
            <div class="w-full sm:w-44">
                <div class="custom-select-wrapper">
                    <div class="custom-select-trigger" onclick="togglePerPageDropdown()">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span class="custom-select-value text-xs sm:text-sm" id="per_page_selected_text">
                                {{ request('per_page', 20) }} po stranici
                            </span>
                        </div>
                        <svg class="custom-select-arrow w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="custom-select-dropdown" id="per-page-dropdown">
                        <div class="custom-select-options">
                            @foreach ([10, 20, 30, 40, 50, 100] as $option)
                                <div class="custom-select-option {{ request('per_page', 20) == $option ? 'selected' : '' }}"
                                    onclick="selectPerPageOption({{ $option }})">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs sm:text-sm">{{ $option }} po stranici</span>
                                        @if (request('per_page', 20) == $option)
                                            <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Logs List -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            @if($logs->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($logs as $log)
                        <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors">
                            <!-- User Info & Timestamp - Mobile First -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                        <span class="text-xs sm:text-sm font-bold text-primary-700">
                                            {{ strtoupper(substr($log->user->name ?? 'N/A', 0, 2)) }}
                                        </span>
                                    </div>
                                    
                                    <!-- User Name & Time -->
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">
                                            {{ $log->user->name ?? 'Nepoznat korisnik' }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-gray-500">
                                            {{ $log->created_at->format('d.m.Y H:i') }}
                                            <span class="hidden sm:inline">• {{ $log->created_at->locale('sr')->diffForHumans() }}</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Date Badge (Desktop) -->
                                <div class="hidden sm:block ml-4 text-right flex-shrink-0">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $log->created_at->format('d.m.Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $log->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Action & Entity Badges -->
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <!-- Action Badge -->
                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $log->action_type === 'create' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                    {{ $log->action_type === 'update' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                    {{ $log->action_type === 'delete' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                                    {{ $log->action_type === 'replenish' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                    {{ $log->action_type === 'set' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}">
                                    {{ $log->getActionLabel() }}
                                </span>

                                <!-- Entity Badge -->
                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $log->getEntityLabel() }}
                                </span>
                                
                                <!-- Mobile timestamp -->
                                <span class="sm:hidden text-xs text-gray-500 ml-auto">
                                    {{ $log->created_at->locale('sr')->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-sm sm:text-base text-gray-900 font-medium mb-2">{{ $log->description }}</p>

                            <!-- Additional Data -->
                            @if($log->data)
                                @php
                                    $keyLabels = [
                                        'location'       => 'Lokacija',
                                        'client_type'    => 'Tip klijenta',
                                        'client_display' => 'Klijent',
                                        'total_amount'   => 'Ukupan iznos',
                                        'sections_count' => 'Broj usluga',
                                        'items_count'    => 'Broj stavki',
                                        'old_quantity'   => 'Stara količina',
                                        'new_quantity'   => 'Nova količina',
                                        'quantity'       => 'Količina',
                                        'product_name'   => 'Naziv materijala',
                                        'warehouse'      => 'Magacin',
                                        'reason'         => 'Razlog',
                                        'amount'         => 'Iznos',
                                        'invoice_number' => 'Broj fakture',
                                        'status'         => 'Status',
                                        'name'           => 'Naziv',
                                        'unit'           => 'Jedinica mere',
                                        'price'          => 'Cena',
                                        'category'       => 'Kategorija',
                                    ];
                                    $valueLabels = [
                                        'fizicko_lice'  => 'Fizičko lice',
                                        'pravno_lice'   => 'Pravno lice',
                                        'pending'       => 'Na čekanju',
                                        'completed'     => 'Završeno',
                                        'cancelled'     => 'Otkazano',
                                    ];
                                @endphp
                                <div class="mt-3 bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-600 mb-2 uppercase">Detalji:</p>
                                    <div class="grid grid-cols-1 gap-2 text-xs sm:text-sm">
                                        @foreach($log->data as $key => $value)
                                            @if(!is_array($value))
                                                <div class="flex flex-col sm:flex-row sm:items-start">
                                                    <span class="font-semibold text-gray-700 sm:min-w-[120px] mb-1 sm:mb-0">{{ $keyLabels[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                    <span class="text-gray-600 break-words">{{ $valueLabels[$value] ?? $value }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="p-8 sm:p-12 text-center">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-base sm:text-lg font-medium text-gray-900 mb-2">Nema aktivnosti</p>
                    <p class="text-sm sm:text-base text-gray-500">
                        @if(request()->hasAny(['action_type', 'entity_type', 'date_from', 'date_to', 'user_id']))
                            Nema aktivnosti koje odgovaraju izabranim filterima.
                        @else
                            Još uvek nema evidentiranih aktivnosti.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePerPageDropdown() {
        document.getElementById('per-page-dropdown').classList.toggle('active');
    }

    function selectPerPageOption(value) {
        document.getElementById('per_page_selected_text').textContent = value + ' po stranici';

        document.querySelectorAll('#per-page-dropdown .custom-select-option').forEach(option => {
            option.classList.remove('selected');
        });
        event.target.closest('.custom-select-option').classList.add('selected');
        document.getElementById('per-page-dropdown').classList.remove('active');

        const currentParams = new URLSearchParams(window.location.search);
        currentParams.set('per_page', value);
        currentParams.delete('page');
        window.location.href = '{{ route('worker.activity-logs.index') }}?' + currentParams.toString();
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.custom-select-wrapper')) {
            const perPageDropdown = document.getElementById('per-page-dropdown');
            if (perPageDropdown) perPageDropdown.classList.remove('active');
        }
    });
</script>
@endpush
