@extends('layouts.worker')

@section('title', 'Izmeni Ponudu')

@section('content')
    <div class="p-3 sm:p-6 max-w-6xl mx-auto">
        <nav class="mb-4 sm:mb-6">
            <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
                <li><a href="{{ route('worker.ponude.index') }}" class="hover:text-primary-600 transition">Ponude</a></li>
                <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><a href="{{ route('worker.ponude.show', $ponuda) }}" class="hover:text-primary-600 transition">Pregled #{{ $ponuda->id }}</a></li>
                <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li class="text-gray-900 font-medium">Izmeni</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-8 py-4 sm:py-6">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="bg-white/20 p-2 sm:p-3 rounded-lg backdrop-blur-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Izmeni Ponudu #{{ $ponuda->id }}</h1>
                        <p class="text-blue-100 text-xs sm:text-sm mt-0.5">Izmenite podatke o ponudi</p>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="m-3 sm:m-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span class="text-red-800 font-medium text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="m-3 sm:m-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-red-800 font-semibold text-sm mb-1">Molimo ispravite sledeće greške:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li class="text-red-700 text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('worker.ponude.update', $ponuda) }}" method="POST" class="p-3 sm:p-8" id="ponudaForm">
                @csrf @method('PUT')

                <!-- Client Type -->
                <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Tip Klijenta <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-primary-400 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50">
                            <input type="radio" name="client_type" value="fizicko_lice" class="sr-only peer"
                                onchange="toggleClientFields()" {{ old('client_type', $ponuda->client_type) === 'fizicko_lice' ? 'checked' : '' }}>
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <p class="font-semibold text-gray-900 text-sm">Fizičko Lice</p>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-primary-400 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50">
                            <input type="radio" name="client_type" value="pravno_lice" class="sr-only peer"
                                onchange="toggleClientFields()" {{ old('client_type', $ponuda->client_type) === 'pravno_lice' ? 'checked' : '' }}>
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <p class="font-semibold text-gray-900 text-sm">Pravno Lice</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Fizičko lice -->
                <div id="fizicko_lice_fields" class="mb-6 sm:mb-8 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-4 sm:p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Podaci o klijentu</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ime i Prezime *</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $ponuda->client_name) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. Marko Marković">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Adresa</label>
                            <input type="text" name="client_address" value="{{ old('client_address', $ponuda->client_address) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. Ulica bb, Beograd">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telefon</label>
                            <input type="text" name="client_phone" value="{{ old('client_phone', $ponuda->client_phone) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. 060 123 4567">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="client_email" value="{{ old('client_email', $ponuda->client_email) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. klijent@email.com">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                    </div>
                </div>

                <!-- Pravno lice -->
                <div id="pravno_lice_fields" class="mb-6 sm:mb-8 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-4 sm:p-6" style="display:none">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Podaci o firmi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Naziv firme *</label>
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $ponuda->company_name) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. Firma d.o.o.">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">PIB</label>
                            <input type="text" name="pib" value="{{ old('pib', $ponuda->pib) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. 123456789">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Matični broj</label>
                            <input type="text" name="maticni_broj" value="{{ old('maticni_broj', $ponuda->maticni_broj) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" placeholder="npr. 12345678">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Adresa firme</label>
                            <input type="text" name="company_address" value="{{ old('company_address', $ponuda->company_address) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telefon</label>
                            <input type="text" name="client_phone" value="{{ old('client_phone', $ponuda->client_phone) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="client_email" value="{{ old('client_email', $ponuda->client_email) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                    </div>
                </div>

                <!-- Location & rates -->
                <div class="mb-6 sm:mb-8 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-4 sm:p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Lokacija i cene</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokacija radova *</label>
                            <input type="text" name="location" value="{{ old('location', $ponuda->location) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kilometraža (km)</label>
                            <input type="number" name="km_to_destination" value="{{ old('km_to_destination', $ponuda->km_to_destination) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" step="0.1" min="0">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cena rada po satu (RSD)</label>
                            <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $ponuda->hourly_rate) }}"
                                class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base" step="0.01" min="0">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-6 sm:mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Napomena</label>
                    <textarea name="notes" rows="3"
                        class="form-input w-full px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm sm:text-base resize-none"
                        placeholder="Opciona napomena za klijenta...">{{ old('notes', $ponuda->notes) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Opciono</p>
                </div>

                <!-- Sections (pre-filled) -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Stavke ponude</h2>
                        <button type="button" onclick="addSection()"
                            class="hidden sm:inline-flex btn-gradient items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Dodaj Uslugu
                        </button>
                    </div>
                    <div id="sectionsContainer" class="space-y-6"></div>
                    <button type="button" onclick="addSection()"
                        class="sm:hidden mt-4 w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 py-3 rounded-lg shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Dodaj Uslugu
                    </button>
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('worker.ponude.show', $ponuda) }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Otkaži
                    </a>
                    <button type="submit"
                        class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Sačuvaj Izmene
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let sectionIndex = 0;
        const products = @json($products);
        let itemCounters = {};

        // Existing sections data from server
        const existingSections = @json($ponuda->sections->load('items.product'));

        document.addEventListener('DOMContentLoaded', function () {
            toggleClientFields();
            // Load existing sections
            existingSections.forEach(section => {
                addSectionWithData(section);
            });
            if (existingSections.length === 0) addSection();
        });

        function toggleClientFields() {
            const clientType = document.querySelector('input[name="client_type"]:checked').value;
            const fizickoFields = document.getElementById('fizicko_lice_fields');
            const pravnoFields = document.getElementById('pravno_lice_fields');
            const clientNameInput = document.getElementById('client_name');
            const companyNameInput = document.getElementById('company_name');
            if (clientType === 'fizicko_lice') {
                fizickoFields.style.display = 'block';
                pravnoFields.style.display = 'none';
                clientNameInput.required = true;
                companyNameInput.required = false;
            } else {
                fizickoFields.style.display = 'none';
                pravnoFields.style.display = 'block';
                clientNameInput.required = false;
                companyNameInput.required = true;
            }
        }

        function addSectionWithData(sectionData) {
            sectionIndex++;
            const container = document.getElementById('sectionsContainer');
            const html = buildSectionHtml(sectionIndex, sectionData.title, sectionData.hours_spent, sectionData.service_price);
            container.insertAdjacentHTML('beforeend', html);

            if (sectionData.items && sectionData.items.length > 0) {
                sectionData.items.forEach(item => {
                    addItemWithData(sectionIndex, item);
                });
            } else {
                addItem(sectionIndex);
            }
        }

        function addSection() {
            sectionIndex++;
            const container = document.getElementById('sectionsContainer');
            container.insertAdjacentHTML('beforeend', buildSectionHtml(sectionIndex, '', '', ''));
            addItem(sectionIndex);
        }

        function buildSectionHtml(idx, title, hours, servicePrice) {
            return `
                <div class="section-block bg-gray-50 border-2 border-gray-200 rounded-xl p-3 sm:p-6 animate-scale-in" data-section="${idx}">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Usluga ${idx}
                        </h3>
                        <button type="button" onclick="removeSection(${idx})" class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Naziv Usluge *</label>
                        <input type="text" name="sections[${idx}][title]"
                            value="${title || ''}"
                            class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                            placeholder="npr. Montaža, Materijal, itd." required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Utrošeni radni sati</label>
                            <input type="number" name="sections[${idx}][hours_spent]"
                                value="${hours || ''}"
                                class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                step="0.25" min="0">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cena usluge (RSD)</label>
                            <input type="number" name="sections[${idx}][service_price]"
                                value="${servicePrice || ''}"
                                class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                step="0.01" min="0">
                            <p class="mt-1 text-xs text-gray-500">Opciono</p>
                        </div>
                    </div>
                    <div class="space-y-3" id="itemsContainer_${idx}"></div>
                    <button type="button" onclick="addItem(${idx})"
                        class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Dodaj Stavku
                    </button>
                </div>`;
        }

        function removeSection(sectionId) {
            document.querySelector(`[data-section="${sectionId}"]`)?.remove();
        }

        function addItemWithData(sectionId, itemData) {
            if (!itemCounters[sectionId]) itemCounters[sectionId] = 0;
            itemCounters[sectionId]++;
            const itemId = itemCounters[sectionId];
            const container = document.getElementById(`itemsContainer_${sectionId}`);
            container.insertAdjacentHTML('beforeend', buildItemHtml(sectionId, itemId));

            // Pre-select the product
            if (itemData.product_id) {
                const product = products.find(p => p.id === itemData.product_id);
                if (product) {
                    const displayText = `${product.name} - ${product.price} RSD/${product.unit}`;
                    document.getElementById(`productInput_${sectionId}_${itemId}`).value = product.id;
                    const valueDisplay = document.getElementById(`selectValue_${sectionId}_${itemId}`);
                    valueDisplay.textContent = displayText;
                    valueDisplay.classList.add('selected');
                }
            }

            // Pre-set quantity
            const qtyInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
            if (qtyInput && itemData.quantity) {
                qtyInput.value = itemData.quantity;
                updateItemPrice(sectionId, itemId);
            }
        }

        function addItem(sectionId) {
            if (!itemCounters[sectionId]) itemCounters[sectionId] = 0;
            itemCounters[sectionId]++;
            const itemId = itemCounters[sectionId];
            const container = document.getElementById(`itemsContainer_${sectionId}`);
            container.insertAdjacentHTML('beforeend', buildItemHtml(sectionId, itemId));
        }

        function buildItemHtml(sectionId, itemId) {
            const options = products.map(p => {
                const n = p.name.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                const u = p.unit.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                return `<div class="custom-select-option"
                    data-value="${p.id}" data-price="${p.price}"
                    data-text="${n} - ${p.price} RSD/${u}"
                    data-search="${p.name.toLowerCase()}"
                    onclick="selectProduct(${sectionId}, ${itemId}, ${p.id}, '${n} - ${p.price} RSD/${u}', ${p.price})">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${n}</div>
                            <div class="text-xs text-gray-500">${p.price} RSD/${u}</div>
                        </div>
                    </div>
                </div>`;
            }).join('');

            return `
                <div class="item-row bg-white border border-gray-300 rounded-lg p-3" data-item="${itemId}">
                    <div class="mb-2">
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-medium text-gray-700">Materijal</label>
                            <button type="button" onclick="removeItem(${sectionId}, ${itemId})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="custom-select-wrapper" id="selectWrapper_${sectionId}_${itemId}">
                            <input type="hidden" name="sections[${sectionId}][items][${itemId}][product_id]" id="productInput_${sectionId}_${itemId}">
                            <div class="custom-select-trigger" onclick="toggleDropdown(${sectionId}, ${itemId})">
                                <span class="custom-select-value" id="selectValue_${sectionId}_${itemId}">Izaberite materijal</span>
                                <svg class="custom-select-arrow w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div class="custom-select-dropdown" id="dropdown_${sectionId}_${itemId}">
                                <div class="custom-select-search">
                                    <svg class="search-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <input type="text" class="custom-select-search-input" id="searchInput_${sectionId}_${itemId}"
                                        placeholder="Pretraži materijale..." oninput="filterProducts(${sectionId}, ${itemId})">
                                </div>
                                <div class="custom-select-options" id="options_${sectionId}_${itemId}">${options}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-28 shrink-0">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Količina</label>
                            <input type="number" name="sections[${sectionId}][items][${itemId}][quantity]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                                min="1" value="1"
                                oninput="updateItemPrice(${sectionId}, ${itemId})"
                                onchange="updateItemPrice(${sectionId}, ${itemId})">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Ukupno</label>
                            <div class="text-sm font-bold text-primary-700 px-3 py-2 bg-primary-50 rounded-lg" id="itemPrice_${sectionId}_${itemId}">0.00 RSD</div>
                        </div>
                    </div>
                </div>`;
        }

        function removeItem(sectionId, itemId) {
            document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"]`)?.remove();
        }

        function updateItemPrice(sectionId, itemId) {
            const hiddenInput = document.getElementById(`productInput_${sectionId}_${itemId}`);
            const qtyInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
            const priceDisplay = document.getElementById(`itemPrice_${sectionId}_${itemId}`);
            if (!hiddenInput || !qtyInput || !priceDisplay) return;
            const selectedOption = document.querySelector(`#options_${sectionId}_${itemId} [data-value="${hiddenInput.value}"]`);
            const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) || 0 : 0;
            priceDisplay.textContent = (price * (parseInt(qtyInput.value) || 0)).toFixed(2) + ' RSD';
        }

        function toggleDropdown(sectionId, itemId) {
            const dropdown = document.getElementById(`dropdown_${sectionId}_${itemId}`);
            document.querySelectorAll('.custom-select-dropdown').forEach(dd => {
                if (dd.id !== `dropdown_${sectionId}_${itemId}`) dd.classList.remove('active');
            });
            dropdown.classList.toggle('active');
            if (dropdown.classList.contains('active')) {
                setTimeout(() => document.getElementById(`searchInput_${sectionId}_${itemId}`).focus(), 100);
            }
        }

        function selectProduct(sectionId, itemId, productId, productText, price) {
            document.getElementById(`productInput_${sectionId}_${itemId}`).value = productId;
            const valueDisplay = document.getElementById(`selectValue_${sectionId}_${itemId}`);
            valueDisplay.textContent = productText;
            valueDisplay.classList.add('selected');
            document.getElementById(`dropdown_${sectionId}_${itemId}`).classList.remove('active');
            updateItemPrice(sectionId, itemId);
        }

        function filterProducts(sectionId, itemId) {
            const term = document.getElementById(`searchInput_${sectionId}_${itemId}`).value.toLowerCase();
            document.querySelectorAll(`#options_${sectionId}_${itemId} .custom-select-option`).forEach(opt => {
                opt.style.display = opt.getAttribute('data-search').includes(term) ? 'block' : 'none';
            });
        }

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.custom-select-wrapper')) {
                document.querySelectorAll('.custom-select-dropdown').forEach(dd => dd.classList.remove('active'));
            }
        });
    </script>
@endsection
