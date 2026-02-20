{{-- Contact Selector Dropdown for auto-filling client data --}}
@if(isset($contacts) && $contacts->count() > 0)
<div class="mb-6 sm:mb-8 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-xl p-4 sm:p-6">
    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Izaberi Sačuvani Kontakt
    </label>
    <p class="text-xs text-gray-600 mb-3">Izaberite kontakt za automatsko popunjavanje podataka</p>
    <div class="custom-select-wrapper" id="contact-select-wrapper">
        <div class="custom-select-trigger" onclick="toggleContactDropdown()" id="contact-select-trigger">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="custom-select-value text-sm sm:text-base" id="contact_selected_text">Izaberite kontakt (opciono)</span>
            </div>
            <svg class="custom-select-arrow w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div class="custom-select-dropdown" id="contact-dropdown">
            <div class="custom-select-search">
                <svg class="search-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" class="custom-select-search-input" id="contactSearchInput"
                    placeholder="Pretraži kontakte..." oninput="filterContacts()">
            </div>
            <div class="custom-select-options" id="contact-options">
                @foreach($contacts as $contact)
                    <div class="custom-select-option" 
                        data-contact-id="{{ $contact->id }}"
                        data-search="{{ strtolower($contact->type === 'fizicko_lice' ? $contact->client_name : $contact->company_name) }} {{ strtolower($contact->client_phone ?? '') }} {{ strtolower($contact->client_email ?? '') }} {{ strtolower($contact->pib ?? '') }}"
                        onclick="selectContact({{ $contact->id }})">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 {{ $contact->type === 'fizicko_lice' ? 'bg-blue-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($contact->type === 'fizicko_lice')
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @else
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $contact->type === 'fizicko_lice' ? $contact->client_name : $contact->company_name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $contact->type === 'fizicko_lice' ? 'Fizičko lice' : 'Pravno lice' }}
                                    @if($contact->client_phone) &middot; {{ $contact->client_phone }} @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
