@extends('layouts.worker')

@section('title', 'Kontakti')

@section('content')
<div class="p-3 sm:p-6 max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.settings.index') }}" class="hover:text-primary-600 transition">Podešavanja</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Kontakti</li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-5 sm:py-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2.5 rounded-xl backdrop-blur-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Kontakti</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">{{ $contacts->count() }} {{ $contacts->count() == 1 ? 'kontakt' : 'kontakata' }}</p>
                    </div>
                </div>
                <button type="button" onclick="openAddModal()"
                    class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-3 sm:px-5 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Dodaj Kontakt</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="mx-3 sm:mx-6 mt-4 bg-green-50 border border-green-200 p-3 rounded-xl flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-3 sm:mx-6 mt-4 bg-red-50 border border-red-200 p-3 rounded-xl flex items-start gap-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-700 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="p-4 sm:p-6">
            @if($contacts->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16 sm:py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl mb-5">
                        <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Nemate kontakata</h3>
                    <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">Sačuvajte kontakte za brže popunjavanje podataka na radnim nalozima i ponudama</p>
                    <button type="button" onclick="openAddModal()"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Dodaj Prvi Kontakt
                    </button>
                </div>
            @else
                <!-- Search Bar -->
                <div class="mb-5">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="contactSearch" placeholder="Pretraži kontakte..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white transition-all"
                            oninput="filterContactsList()">
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-col sm:flex-row gap-2 mb-5">
                    <button type="button" onclick="setFilter('all')" id="filter_all"
                        class="filter-tab inline-flex items-center gap-1.5 px-4 py-2.5 sm:py-2 rounded-xl sm:rounded-full text-sm font-semibold transition-all bg-gradient-to-r from-primary-600 to-primary-700 text-white shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Svi
                        <span class="ml-auto sm:ml-0 px-1.5 py-0.5 rounded-full text-xs bg-white/25">{{ $contacts->count() }}</span>
                    </button>
                    <button type="button" onclick="setFilter('fizicko_lice')" id="filter_fizicko_lice"
                        class="filter-tab inline-flex items-center gap-1.5 px-4 py-2.5 sm:py-2 rounded-xl sm:rounded-full text-sm font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Fizička Lica
                        <span class="ml-auto sm:ml-0 px-1.5 py-0.5 rounded-full text-xs bg-black/8">{{ $contacts->where('type', 'fizicko_lice')->count() }}</span>
                    </button>
                    <button type="button" onclick="setFilter('pravno_lice')" id="filter_pravno_lice"
                        class="filter-tab inline-flex items-center gap-1.5 px-4 py-2.5 sm:py-2 rounded-xl sm:rounded-full text-sm font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Pravna Lica
                        <span class="ml-auto sm:ml-0 px-1.5 py-0.5 rounded-full text-xs bg-black/8">{{ $contacts->where('type', 'pravno_lice')->count() }}</span>
                    </button>
                </div>

                <!-- Contact Cards -->
                <div class="space-y-3" id="contactsList">
                    @foreach($contacts as $contact)
                        <div class="contact-card group relative bg-white border border-gray-200 rounded-xl hover:border-primary-300 hover:shadow-lg transition-all duration-200 overflow-hidden"
                            data-type="{{ $contact->type }}"
                            data-search="{{ strtolower(($contact->client_name ?? '') . ' ' . ($contact->company_name ?? '') . ' ' . ($contact->client_phone ?? '') . ' ' . ($contact->client_email ?? '') . ' ' . ($contact->pib ?? '') . ' ' . ($contact->company_address ?? '') . ' ' . ($contact->client_address ?? '')) }}">

                            {{-- Color accent bar --}}
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $contact->type === 'fizicko_lice' ? 'bg-blue-500' : 'bg-emerald-500' }} rounded-l-xl"></div>

                            <div class="p-4 pl-5">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    {{-- Avatar --}}
                                    <div class="hidden sm:block flex-shrink-0">
                                        @if($contact->type === 'fizicko_lice')
                                            <div class="w-11 h-11 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                                <span class="text-white font-bold text-sm sm:text-base">{{ strtoupper(mb_substr($contact->client_name ?? '?', 0, 1)) }}{{ strtoupper(mb_substr(explode(' ', $contact->client_name ?? '')[1] ?? '', 0, 1)) }}</span>
                                            </div>
                                        @else
                                            <div class="w-11 h-11 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Contact Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-bold text-gray-900 text-base sm:text-lg truncate">
                                                    {{ $contact->type === 'fizicko_lice' ? $contact->client_name : $contact->company_name }}
                                                </h3>
                                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $contact->type === 'fizicko_lice' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                        {{ $contact->type === 'fizicko_lice' ? 'Fizičko lice' : 'Pravno lice' }}
                                                    </span>
                                                    @if($contact->type === 'pravno_lice' && $contact->pib)
                                                        <span class="text-xs text-gray-500">PIB: {{ $contact->pib }}</span>
                                                    @endif
                                                    @if($contact->type === 'pravno_lice' && $contact->maticni_broj)
                                                        <span class="text-xs text-gray-500">MB: {{ $contact->maticni_broj }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Desktop Action Buttons --}}
                                            <div class="hidden sm:flex items-center gap-0.5 flex-shrink-0">
                                                <button type="button" onclick="openEditModal({{ $contact->id }})"
                                                    class="p-2.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors"
                                                    title="Izmeni">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <form action="{{ route('worker.contacts.destroy', $contact) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Da li ste sigurni da želite obrisati kontakt {{ $contact->type === 'fizicko_lice' ? addslashes($contact->client_name) : addslashes($contact->company_name) }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                        title="Obriši">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Contact Details --}}
                                        <div class="mt-2.5 flex flex-col sm:flex-row sm:flex-wrap gap-y-2 sm:gap-y-1.5 sm:gap-x-4 text-sm text-gray-600">
                                            @if($contact->type === 'pravno_lice' && $contact->client_name)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    <span class="truncate">{{ $contact->client_name }}</span>
                                                </div>
                                            @endif
                                            @if($contact->type === 'fizicko_lice' ? $contact->client_address : $contact->company_address)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    <span class="truncate">{{ $contact->type === 'fizicko_lice' ? $contact->client_address : $contact->company_address }}</span>
                                                </div>
                                            @endif
                                            @if($contact->client_phone)
                                                <a href="tel:{{ $contact->client_phone }}" class="flex items-center gap-2 text-primary-600 sm:text-gray-600 sm:hover:text-primary-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0 sm:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    <span class="font-medium sm:font-normal">{{ $contact->client_phone }}</span>
                                                </a>
                                            @endif
                                            @if($contact->client_email)
                                                <a href="mailto:{{ $contact->client_email }}" class="flex items-center gap-2 hover:text-primary-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    <span class="truncate">{{ $contact->client_email }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Mobile Action Bar --}}
                                <div class="sm:hidden flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                                    @if($contact->client_phone)
                                        <a href="tel:{{ $contact->client_phone }}"
                                            class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-primary-50 text-primary-700 font-semibold rounded-lg text-sm transition-colors active:bg-primary-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            Pozovi
                                        </a>
                                    @endif
                                    <button type="button" onclick="openEditModal({{ $contact->id }})"
                                        class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm transition-colors active:bg-gray-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Izmeni
                                    </button>
                                    <form action="{{ route('worker.contacts.destroy', $contact) }}" method="POST"
                                        onsubmit="return confirm('Da li ste sigurni da želite obrisati kontakt {{ $contact->type === 'fizicko_lice' ? addslashes($contact->client_name) : addslashes($contact->company_name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center gap-2 py-2.5 px-4 bg-red-50 text-red-600 font-semibold rounded-lg text-sm transition-colors active:bg-red-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- No results message --}}
                <div id="noResults" class="hidden text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Nema rezultata pretrage</p>
                    <p class="text-gray-400 text-sm mt-1">Pokušajte sa drugim pojmom</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add/Edit Contact Modal -->
<div id="contactModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="fixed inset-0 flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="bg-white w-full sm:rounded-2xl sm:max-w-lg sm:w-full max-h-[95vh] sm:max-h-[90vh] overflow-hidden relative shadow-2xl rounded-t-2xl sm:rounded-2xl animate-slide-up" onclick="event.stopPropagation()">
            {{-- Modal Header --}}
            <div class="sticky top-0 z-10 bg-white border-b border-gray-100 px-5 sm:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900" id="modalTitle">Dodaj Kontakt</h2>
                </div>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-2 -mr-2 rounded-xl hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="contactForm" method="POST" class="overflow-y-auto" style="max-height: calc(95vh - 130px)">
                @csrf
                <div id="contactMethodField"></div>

                <div class="p-5 sm:p-6 space-y-5">
                    <!-- Contact Type Toggle -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2.5">Tip Kontakta</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="relative flex items-center justify-center gap-2 p-3.5 border-2 rounded-xl cursor-pointer transition-all hover:border-blue-300 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-sm">
                                <input type="radio" name="type" value="fizicko_lice" class="sr-only peer" onchange="toggleModalFields()" checked>
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="font-semibold text-gray-900 text-sm">Fizičko Lice</span>
                            </label>
                            <label class="relative flex items-center justify-center gap-2 p-3.5 border-2 rounded-xl cursor-pointer transition-all hover:border-emerald-300 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 has-[:checked]:shadow-sm">
                                <input type="radio" name="type" value="pravno_lice" class="sr-only peer" onchange="toggleModalFields()">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-semibold text-gray-900 text-sm">Pravno Lice</span>
                            </label>
                        </div>
                    </div>

                    <!-- Fizicko lice fields -->
                    <div id="modal_fizicko_fields" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ime i Prezime <span class="text-red-500">*</span></label>
                            <input type="text" name="client_name" id="modal_client_name"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="npr. Marko Marković">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresa</label>
                            <input type="text" name="client_address" id="modal_client_address"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="npr. Ulica bb, Beograd">
                        </div>
                    </div>

                    <!-- Pravno lice fields -->
                    <div id="modal_pravno_fields" style="display:none" class="space-y-4">
                        <!-- APR Company Search Helper -->
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span class="text-sm font-semibold text-emerald-800">Pretraži APR bazu</span>
                            </div>
                            <p class="text-xs text-emerald-700 mb-2">Pronađite podatke firme na sajtu Agencije za privredne registre.</p>
                            <button type="button" onclick="openAprSearch()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm w-full justify-center sm:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Otvori APR pretragu
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Naziv firme <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name" id="modal_company_name"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="npr. Firma d.o.o.">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kontakt osoba</label>
                            <input type="text" name="client_name" id="modal_pravno_client_name"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="npr. Ime i prezime kontakt osobe">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">PIB</label>
                                <input type="text" name="pib" id="modal_pib"
                                    class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                    placeholder="123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Matični broj</label>
                                <input type="text" name="maticni_broj" id="modal_maticni_broj"
                                    class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                    placeholder="12345678">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresa firme</label>
                            <input type="text" name="company_address" id="modal_company_address"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="npr. Ulica bb, Beograd">
                        </div>
                    </div>

                    <!-- Common fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telefon</label>
                            <input type="text" name="client_phone" id="modal_client_phone"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="060 123 4567">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="client_email" id="modal_client_email"
                                class="form-input w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white text-sm transition-all"
                                placeholder="email@primer.com">
                        </div>
                    </div>
                </div>

                <!-- Sticky Actions -->
                <div class="sticky bottom-0 bg-white border-t border-gray-100 px-5 sm:px-6 py-4 flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 sm:flex-none px-5 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors text-sm">
                        Otkaži
                    </button>
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span id="modalSubmitText">Sačuvaj</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes slide-up {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }
    @media (min-width: 640px) {
        .animate-slide-up {
            animation: none;
        }
    }
</style>

<script>
    const contacts = @json($contacts);
    let activeFilter = 'all';

    // ==================== APR Company Search Helper ====================

    function openAprSearch() {
        window.open('https://pretraga.apr.gov.rs/search', '_blank', 'noopener');
    }

    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Dodaj Kontakt';
        document.getElementById('modalSubmitText').textContent = 'Sačuvaj';
        document.getElementById('contactForm').action = '{{ route("worker.contacts.store") }}';
        document.getElementById('contactMethodField').innerHTML = '';

        // Reset all fields
        ['modal_client_name', 'modal_client_address', 'modal_client_phone', 'modal_client_email',
         'modal_company_name', 'modal_pravno_client_name', 'modal_pib', 'modal_maticni_broj', 'modal_company_address'
        ].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });

        // Reset to fizicko_lice
        document.querySelector('#contactForm input[name="type"][value="fizicko_lice"]').checked = true;
        toggleModalFields();

        document.getElementById('contactModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function openEditModal(contactId) {
        const contact = contacts.find(c => c.id === contactId);
        if (!contact) return;

        document.getElementById('modalTitle').textContent = 'Izmeni Kontakt';
        document.getElementById('modalSubmitText').textContent = 'Ažuriraj';
        document.getElementById('contactForm').action = `/worker/contacts/${contactId}`;
        document.getElementById('contactMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        // Fill fields
        document.getElementById('modal_client_name').value = contact.client_name || '';
        document.getElementById('modal_client_address').value = contact.client_address || '';
        document.getElementById('modal_client_phone').value = contact.client_phone || '';
        document.getElementById('modal_client_email').value = contact.client_email || '';
        document.getElementById('modal_company_name').value = contact.company_name || '';
        document.getElementById('modal_pravno_client_name').value = contact.client_name || '';
        document.getElementById('modal_pib').value = contact.pib || '';
        document.getElementById('modal_maticni_broj').value = contact.maticni_broj || '';
        document.getElementById('modal_company_address').value = contact.company_address || '';

        // Set type
        document.querySelector(`#contactForm input[name="type"][value="${contact.type}"]`).checked = true;
        toggleModalFields();

        document.getElementById('contactModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function toggleModalFields() {
        const type = document.querySelector('#contactForm input[name="type"]:checked').value;
        document.getElementById('modal_fizicko_fields').style.display = type === 'fizicko_lice' ? 'block' : 'none';
        document.getElementById('modal_pravno_fields').style.display = type === 'pravno_lice' ? 'block' : 'none';
    }

    const activeClasses = ['bg-gradient-to-r', 'from-primary-600', 'to-primary-700', 'text-white', 'shadow-md'];
    const inactiveClasses = ['bg-gray-100', 'text-gray-600', 'hover:bg-gray-200'];

    function setFilter(type) {
        activeFilter = type;
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove(...activeClasses, ...inactiveClasses);
            const isActive = tab.id === 'filter_' + type;
            tab.classList.add(...(isActive ? activeClasses : inactiveClasses));
            const badge = tab.querySelector('span');
            if (badge) {
                badge.classList.remove('bg-white/25', 'bg-black/8');
                badge.classList.add(isActive ? 'bg-white/25' : 'bg-black/8');
            }
        });
        filterContactsList();
    }

    function filterContactsList() {
        const search = (document.getElementById('contactSearch')?.value || '').toLowerCase();
        const cards = document.querySelectorAll('.contact-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const matchesType = activeFilter === 'all' || card.dataset.type === activeFilter;
            const matchesSearch = !search || card.dataset.search.includes(search);
            const visible = matchesType && matchesSearch;
            card.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        const noResults = document.getElementById('noResults');
        if (noResults) {
            noResults.classList.toggle('hidden', visibleCount > 0);
        }
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endsection
