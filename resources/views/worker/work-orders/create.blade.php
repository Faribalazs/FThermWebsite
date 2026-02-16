@extends('layouts.worker')

@section('title', 'Novi Radni Nalog')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Novi Radni Nalog</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Kreiraj Radni Nalog</h1>
                    <p class="text-primary-100 text-sm mt-1">Popunite podatke o radnom nalogu i dodajte sekcije</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="m-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Body -->
        <form action="{{ route('worker.work-orders.store') }}" method="POST" class="p-8" id="workOrderForm">
            @csrf
            
            <!-- Client Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="client_name">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ime Klijenta
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="client_name" 
                        id="client_name" 
                        value="{{ old('client_name') }}"
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('client_name') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="Unesite ime klijenta"
                        required
                    >
                    @error('client_name')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="location">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Lokacija
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        value="{{ old('location') }}"
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('location') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="Unesite lokaciju"
                        required
                    >
                    @error('location')
                        <div class="mt-2 flex items-center gap-2 text-red-600 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2" for="hourly_rate">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cena po satu (RSD)
                    </label>
                    <input 
                        type="number" 
                        name="hourly_rate" 
                        id="hourly_rate" 
                        value="{{ old('hourly_rate') }}"
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                        placeholder="Npr. 1500"
                        step="0.01"
                        min="0"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opciono - Ako želite da računate cenu po utrošenim satima</p>
                </div>
            </div>

            <!-- Sections -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Sekcije i Stavke</h2>
                    <button type="button" onclick="addSection()" class="btn-gradient inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Dodaj Sekciju
                    </button>
                </div>

                <div id="sectionsContainer" class="space-y-6">
                    <!-- Sections will be added here dynamically -->
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Otkaži
                </a>
                <button type="submit" class="btn-gradient inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj Radni Nalog
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let sectionIndex = 0;
const products = @json($products);

// Add first section on page load
document.addEventListener('DOMContentLoaded', function() {
    addSection();
});

function addSection() {
    sectionIndex++;
    const container = document.getElementById('sectionsContainer');
    
    const sectionHtml = `
        <div class="section-block bg-gray-50 border-2 border-gray-200 rounded-xl p-6 animate-scale-in" data-section="${sectionIndex}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Sekcija ${sectionIndex}
                </h3>
                <button type="button" onclick="removeSection(${sectionIndex})" class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Naziv Sekcije *</label>
                <input 
                    type="text" 
                    name="sections[${sectionIndex}][title]" 
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="npr. Montaža, Materijal, itd."
                    required
                >
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Utrošeno vreme (sati)
                </label>
                <input 
                    type="number" 
                    name="sections[${sectionIndex}][hours_spent]" 
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="npr. 2.5"
                    step="0.25"
                    min="0"
                >
                <p class="mt-1 text-xs text-gray-500">Opciono - Koliko sati je utrošeno na ovu sekciju</p>
            </div>

            <div class="space-y-3" id="itemsContainer_${sectionIndex}">
                <!-- Items will be added here -->
            </div>

            <button type="button" onclick="addItem(${sectionIndex})" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Dodaj Stavku
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
    addItem(sectionIndex); // Add first item automatically
}

function removeSection(sectionId) {
    const section = document.querySelector(`[data-section="${sectionId}"]`);
    if (section) {
        section.remove();
    }
}

let itemCounters = {};

function addItem(sectionId) {
    if (!itemCounters[sectionId]) {
        itemCounters[sectionId] = 0;
    }
    itemCounters[sectionId]++;
    
    const itemId = itemCounters[sectionId];
    const container = document.getElementById(`itemsContainer_${sectionId}`);
    
    let productOptions = '<option value="">Izaberite proizvod</option>';
    products.forEach(product => {
        productOptions += `<option value="${product.id}" data-price="${product.price}">${product.name} - ${product.price} RSD/${product.unit}</option>`;
    });
    
    const itemHtml = `
        <div class="item-row bg-white border border-gray-300 rounded-lg p-4 flex gap-4 items-start" data-item="${itemId}">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-700 mb-1">Proizvod *</label>
                <select 
                    name="sections[${sectionId}][items][${itemId}][product_id]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                    required
                    onchange="updateItemPrice(${sectionId}, ${itemId})"
                >
                    ${productOptions}
                </select>
            </div>
            <div class="w-32">
                <label class="block text-xs font-medium text-gray-700 mb-1">Količina *</label>
                <input 
                    type="number" 
                    name="sections[${sectionId}][items][${itemId}][quantity]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                    min="1"
                    value="1"
                    required
                    onchange="updateItemPrice(${sectionId}, ${itemId})"
                >
            </div>
            <div class="w-32">
                <label class="block text-xs font-medium text-gray-700 mb-1">Cena</label>
                <div class="text-sm font-bold text-gray-900 px-3 py-2 bg-gray-50 rounded-lg" id="itemPrice_${sectionId}_${itemId}">
                    0.00 RSD
                </div>
            </div>
            <div class="pt-6">
                <button type="button" onclick="removeItem(${sectionId}, ${itemId})" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}

function removeItem(sectionId, itemId) {
    const item = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"]`);
    if (item) {
        item.remove();
    }
}

function updateItemPrice(sectionId, itemId) {
    const selectElement = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] select`);
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    const priceDisplay = document.getElementById(`itemPrice_${sectionId}_${itemId}`);
    
    if (selectElement && quantityInput && priceDisplay) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        
        priceDisplay.textContent = total.toFixed(2) + ' RSD';
    }
}
</script>
@endsection
