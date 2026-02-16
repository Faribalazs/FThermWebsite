@extends('layouts.worker')

@section('title', 'Novi Radni Nalog')

@section('content')
<div class="p-3 sm:p-6 max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Novi Radni Nalog</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="bg-white/20 p-2 sm:p-3 rounded-lg backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">Kreiraj Radni Nalog</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Popunite podatke o radnom nalogu i dodajte sekcije</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="m-3 sm:m-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-500 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-medium text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Body -->
        <form action="{{ route('worker.work-orders.store') }}" method="POST" class="p-3 sm:p-8" id="workOrderForm">
            @csrf
            
            <!-- Client Info -->
            <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div>
                    <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="client_name">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('client_name') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="Unesite ime klijenta"
                        required
                    >
                    @error('client_name')
                        <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2" for="location">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all @error('location') border-red-500 ring-2 ring-red-200 error @enderror"
                        placeholder="Unesite lokaciju"
                        required
                    >
                    @error('location')
                        <div class="mt-1 sm:mt-2 flex items-center gap-1 sm:gap-2 text-red-600 text-xs sm:text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
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
    
    const itemHtml = `
        <div class="item-row bg-white border border-gray-300 rounded-lg p-4 flex gap-4 items-start" data-item="${itemId}">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-700 mb-1">Materijal *</label>
                <div class="custom-select-wrapper" id="selectWrapper_${sectionId}_${itemId}">
                    <input type="hidden" 
                        name="sections[${sectionId}][items][${itemId}][product_id]" 
                        id="productInput_${sectionId}_${itemId}"
                        required>
                    <div class="custom-select-trigger" onclick="toggleDropdown(${sectionId}, ${itemId})">
                        <span class="custom-select-value" id="selectValue_${sectionId}_${itemId}">Izaberite materijal</span>
                        <svg class="custom-select-arrow w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="custom-select-dropdown" id="dropdown_${sectionId}_${itemId}">
                        <div class="custom-select-search">
                            <svg class="search-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" 
                                class="custom-select-search-input" 
                                id="searchInput_${sectionId}_${itemId}"
                                placeholder="Pretraži materijale..."
                                oninput="filterProducts(${sectionId}, ${itemId})">
                        </div>
                        <div class="custom-select-options" id="options_${sectionId}_${itemId}">
                            ${products.map(product => {
                                const stock = product.inventory ? product.inventory.quantity : 0;
                                const stockClass = stock === 0 ? 'text-red-600' : (stock < 10 ? 'text-yellow-600' : 'text-green-600');
                                const stockBg = stock === 0 ? 'bg-red-100' : (stock < 10 ? 'bg-yellow-100' : 'bg-green-100');
                                return `
                                <div class="custom-select-option" 
                                    data-value="${product.id}" 
                                    data-price="${product.price}"
                                    data-stock="${stock}"
                                    data-text="${product.name} - ${product.price} RSD/${product.unit}"
                                    data-search="${product.name.toLowerCase()}"
                                    onclick="selectProduct(${sectionId}, ${itemId}, ${product.id}, \`${product.name} - ${product.price} RSD/${product.unit}\`, ${product.price}, ${stock})">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">${product.name}</div>
                                            <div class="text-xs text-gray-500">${product.price} RSD/${product.unit}</div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-semibold ${stockBg} ${stockClass}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                ${stock}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `}).join('')}
                        </div>
                    </div>
                </div>
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
                    oninput="validateStock(${sectionId}, ${itemId}); updateItemPrice(${sectionId}, ${itemId})"
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
    const hiddenInput = document.getElementById(`productInput_${sectionId}_${itemId}`);
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    const priceDisplay = document.getElementById(`itemPrice_${sectionId}_${itemId}`);
    
    if (hiddenInput && quantityInput && priceDisplay) {
        const productId = hiddenInput.value;
        const selectedOption = document.querySelector(`#options_${sectionId}_${itemId} [data-value="${productId}"]`);
        const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) || 0 : 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        
        priceDisplay.textContent = total.toFixed(2) + ' RSD';
    }
}

// Custom dropdown functions
function toggleDropdown(sectionId, itemId) {
    const dropdown = document.getElementById(`dropdown_${sectionId}_${itemId}`);
    const allDropdowns = document.querySelectorAll('.custom-select-dropdown');
    
    // Close all other dropdowns
    allDropdowns.forEach(dd => {
        if (dd.id !== `dropdown_${sectionId}_${itemId}`) {
            dd.classList.remove('active');
        }
    });
    
    dropdown.classList.toggle('active');
    
    // Focus search input when opening
    if (dropdown.classList.contains('active')) {
        setTimeout(() => {
            document.getElementById(`searchInput_${sectionId}_${itemId}`).focus();
        }, 100);
    }
}

function selectProduct(sectionId, itemId, productId, productText, price, stock) {
    const hiddenInput = document.getElementById(`productInput_${sectionId}_${itemId}`);
    const valueDisplay = document.getElementById(`selectValue_${sectionId}_${itemId}`);
    const dropdown = document.getElementById(`dropdown_${sectionId}_${itemId}`);
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    
    hiddenInput.value = productId;
    valueDisplay.textContent = productText;
    valueDisplay.classList.add('selected');
    dropdown.classList.remove('active');
    
    // Store stock level as data attribute on quantity input
    if (quantityInput) {
        quantityInput.setAttribute('data-stock', stock);
        quantityInput.setAttribute('max', stock > 0 ? stock : 999999);
        
        // Add validation message container if it doesn't exist
        if (!quantityInput.parentElement.querySelector('.stock-warning')) {
            const warning = document.createElement('div');
            warning.className = 'stock-warning text-xs mt-1 hidden';
            quantityInput.parentElement.appendChild(warning);
        }
    }
    
    // Update price
    updateItemPrice(sectionId, itemId);
}

function validateStock(sectionId, itemId) {
    const quantityInput = document.querySelector(`[data-section="${sectionId}"] [data-item="${itemId}"] input[type="number"]`);
    
    if (!quantityInput) return;
    
    const stock = parseInt(quantityInput.getAttribute('data-stock')) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    let warning = quantityInput.parentElement.querySelector('.stock-warning');
    
    if (!warning) {
        warning = document.createElement('div');
        warning.className = 'stock-warning text-xs mt-1';
        quantityInput.parentElement.appendChild(warning);
    }
    
    if (quantity > stock) {
        warning.className = 'stock-warning text-xs mt-1 text-red-600 font-medium flex items-center gap-1';
        warning.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Nedovoljno zaliha! (Dostupno: ${stock})
        `;
        quantityInput.classList.add('border-red-500');
    } else if (quantity === stock && stock > 0) {
        warning.className = 'stock-warning text-xs mt-1 text-yellow-600 font-medium flex items-center gap-1';
        warning.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Koristi svu dostupnu zalihu
        `;
        quantityInput.classList.remove('border-red-500');
    } else {
        warning.className = 'stock-warning text-xs mt-1 hidden';
        warning.innerHTML = '';
        quantityInput.classList.remove('border-red-500');
    }
}

function filterProducts(sectionId, itemId) {
    const searchInput = document.getElementById(`searchInput_${sectionId}_${itemId}`);
    const searchTerm = searchInput.value.toLowerCase();
    const options = document.querySelectorAll(`#options_${sectionId}_${itemId} .custom-select-option`);
    
    options.forEach(option => {
        const searchText = option.getAttribute('data-search');
        if (searchText.includes(searchTerm)) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select-wrapper')) {
        document.querySelectorAll('.custom-select-dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
});

// Form validation before submit
document.getElementById('workOrderForm').addEventListener('submit', function(event) {
    const quantityInputs = document.querySelectorAll('input[type="number"][name*="quantity"]');
    let hasStockError = false;
    let errorMessage = '';
    
    quantityInputs.forEach(input => {
        const stock = parseInt(input.getAttribute('data-stock'));
        const quantity = parseInt(input.value) || 0;
        
        if (!isNaN(stock) && quantity > stock) {
            hasStockError = true;
            const itemRow = input.closest('.item-row');
            const productName = itemRow ? itemRow.querySelector('.custom-select-value').textContent : 'Materijal';
            errorMessage += `${productName}: Traženo ${quantity}, dostupno ${stock}\n`;
        }
    });
    
    if (hasStockError) {
        event.preventDefault();
        alert('Nedovoljno zaliha za sledeće materijale:\n\n' + errorMessage + '\nMolimo prilagodite količine.');
        return false;
    }
});

</script>
@endsection
