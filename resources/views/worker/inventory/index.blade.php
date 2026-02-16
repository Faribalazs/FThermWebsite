@extends('layouts.worker')

@section('title', 'Dopuna Zaliha')

@section('content')
<div class="p-3 sm:p-6 w-full">
    <div class="max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-4 animate-fade-in">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold bg-clip-text">
                    Dopuna Zaliha
                </h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Upravljanje zalihama internih materijala</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 bg-white px-3 sm:px-4 py-2 rounded-lg shadow-md border border-gray-200">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-xs sm:text-sm font-semibold text-gray-700">{{ $products->total() }} Materijala</span>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-in alert-success">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-3 sm:p-6 mb-4 sm:mb-6 animate-slide-in">
            <form method="GET" action="{{ route('worker.inventory.index') }}" class="space-y-3 sm:space-y-4">
                <div class="grid grid-cols-1 gap-3 sm:gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Pretraga</label>
                        <div class="relative">
                            <svg class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" 
                                   id="inventory-search"
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Pretražite po imenu ili jedinici..." 
                                   class="form-input w-full pl-8 sm:pl-10 pr-8 sm:pr-10 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <div id="search-loader" class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 hidden">
                                <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Sortiraj po</label>
                        <div class="custom-select-wrapper">
                            <input type="hidden" name="sort_by" id="sort_by_value" value="{{ request('sort_by', 'name') }}">
                            <div class="custom-select-trigger" onclick="toggleSortDropdown()">
                                <span class="custom-select-value text-sm sm:text-base" id="sort_selected_text">{{ request('sort_by') == 'quantity' ? 'Količini' : (request('sort_by') == 'price' ? 'Ceni' : 'Nazivu') }}</span>
                                <svg class="custom-select-arrow w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="custom-select-dropdown" id="sort-dropdown">
                                <div class="custom-select-options">
                                    <div class="custom-select-option {{ request('sort_by', 'name') == 'name' ? 'selected' : '' }}" onclick="selectSortOption('name', 'Nazivu')">
                                        <div class="flex items-center justify-between">
                                            <span>Nazivu</span>
                                        </div>
                                    </div>
                                    <div class="custom-select-option {{ request('sort_by') == 'quantity' ? 'selected' : '' }}" onclick="selectSortOption('quantity', 'Količini')">
                                        <div class="flex items-center justify-between">
                                            <span>Količini</span>
                                        </div>
                                    </div>
                                    <div class="custom-select-option {{ request('sort_by') == 'price' ? 'selected' : '' }}" onclick="selectSortOption('price', 'Ceni')">
                                        <div class="flex items-center justify-between">
                                            <span>Ceni</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Primeni
                    </button>
                    <a href="{{ route('worker.inventory.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Resetuj
                    </a>
                    <button type="button" 
                            onclick="var input = document.querySelector('input[name=sort_order]'); input.value = input.value === 'asc' ? 'desc' : 'asc'; this.closest('form').submit();"
                            class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ request('sort_order') == 'desc' ? 'rotate-180' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        <span class="inline">{{ request('sort_order') == 'desc' ? 'Opadajuće' : 'Rastuće' }}</span>
                    </button>
                    <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') }}">
                </div>
            </form>
        </div>

        <!-- Products Table -->
        @if($products->count() > 0)
        <div class="bg-white rounded-xl shadow-enhanced border border-gray-200 overflow-hidden animate-scale-in w-full">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 modern-table w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Materijal</th>
                            <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jedinica</th>
                            <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Cena</th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Stanje</th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Akcije</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-table-body" class="divide-y divide-gray-200 bg-white">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50" id="product-{{ $product->id }}">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold text-gray-900">{{ $product->name }}</div>                                    </div>
                                </div>
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->unit }}
                                </span>
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4 text-sm font-semibold text-gray-900">
                                {{ number_format($product->price, 2) }} RSD
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                @php
                                    $quantity = $product->inventory->quantity ?? 0;
                                    $statusClass = $quantity == 0 ? 'bg-red-100 text-red-800' : ($quantity < 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-bold {{ $statusClass }}">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">{{ $quantity }} {{ $product->unit }}</span>
                                    <span class="sm:hidden">{{ $quantity }}</span>
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="openAddModal({{ $product->id }}, '{{ $product->name }}', '{{ $product->unit }}')"
                                            class="inline-flex items-center gap-1 px-2 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-xs sm:text-sm font-semibold rounded-lg shadow-md">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Dodaj</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-12 text-center animate-fade-in">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Nema Materijala</h3>
            <p class="text-gray-500">Nema materijala koji zadovoljavaju kriterijume pretrage.</p>
        </div>
        @endif
    </div>
</div>

<!-- Add Quantity Modal -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4" onclick="if(event.target === this) closeAddModal()">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-xl">
            <h2 class="text-2xl font-bold text-white">Dodaj Zalihe</h2>
        </div>

        <form id="addForm" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <p class="text-gray-600 mb-4">Dodajte količinu za materijal: <span id="addProductName" class="font-bold text-gray-900"></span></p>
                
                <label class="block text-sm font-semibold text-gray-700 mb-2">Količina za Dodavanje</label>
                <div class="relative">
                    <input type="number" 
                           name="quantity_to_add" 
                           min="1" 
                           required
                           class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg font-semibold"
                           placeholder="Unesite količinu">
                    <span id="addProductUnit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium"></span>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeAddModal()" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Otkaži
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    Dodaj
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Set Quantity Modal -->
<div id="setModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4" onclick="if(event.target === this) closeSetModal()">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-xl">
            <h2 class="text-2xl font-bold text-white">Postavi Količinu</h2>
        </div>

        <form id="setForm" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <p class="text-gray-600 mb-1">Postavite tačnu količinu za materijal:</p>
                <p class="font-bold text-gray-900 mb-4"><span id="setProductName"></span></p>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-gray-600">Trenutno stanje: <span id="currentQuantity" class="font-bold text-lg text-gray-900"></span> <span id="currentUnit" class="text-gray-600"></span></p>
                </div>
                
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nova Količina</label>
                <div class="relative">
                    <input type="number" 
                           name="quantity" 
                           min="0" 
                           required
                           class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg font-semibold"
                           placeholder="Unesite novu količinu">
                    <span id="setProductUnit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium"></span>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeSetModal()" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Otkaži
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    Postavi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal(productId, productName, productUnit) {
    document.getElementById('addModal').classList.remove('hidden');
    document.getElementById('addModal').classList.add('flex');
    document.getElementById('addProductName').textContent = productName;
    document.getElementById('addProductUnit').textContent = productUnit;
    document.getElementById('addForm').action = `/worker/inventory/${productId}/add`;
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addModal').classList.remove('flex');
    document.getElementById('addForm').reset();
}

function openSetModal(productId, productName, productUnit, currentQty) {
    document.getElementById('setModal').classList.remove('hidden');
    document.getElementById('setModal').classList.add('flex');
    document.getElementById('setProductName').textContent = productName;
    document.getElementById('setProductUnit').textContent = productUnit;
    document.getElementById('currentQuantity').textContent = currentQty;
    document.getElementById('currentUnit').textContent = productUnit;
    document.getElementById('setForm').action = `/worker/inventory/${productId}/set`;
}

function closeSetModal() {
    document.getElementById('setModal').classList.add('hidden');
    document.getElementById('setModal').classList.remove('flex');
    document.getElementById('setForm').reset();
}

// Instant Search Functionality
let searchTimeout;
const searchInput = document.getElementById('inventory-search');
const tableBody = document.getElementById('inventory-table-body');
const paginationContainer = document.getElementById('pagination-container');
const searchLoader = document.getElementById('search-loader');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 300);
    });
}

// Handle pagination clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('#pagination-container a')) {
        e.preventDefault();
        const url = e.target.closest('a').href;
        fetchResults(url);
    }
});

function performSearch() {
    const searchValue = searchInput.value;
    const form = document.querySelector('form');
    const formData = new FormData(form);
    formData.set('search', searchValue);
    
    const params = new URLSearchParams(formData);
    const url = `{{ route('worker.inventory.index') }}?${params.toString()}`;
    
    fetchResults(url);
}

function fetchResults(url) {
    searchLoader.classList.remove('hidden');
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        tableBody.innerHTML = data.html;
        paginationContainer.innerHTML = data.pagination;
        searchLoader.classList.add('hidden');
    })
    .catch(error => {
        console.error('Search error:', error);
        searchLoader.classList.add('hidden');
    });
}

// Custom Sort Dropdown Functions
function toggleSortDropdown() {
    const dropdown = document.getElementById('sort-dropdown');
    dropdown.classList.toggle('active');
}

function selectSortOption(value, text) {
    document.getElementById('sort_by_value').value = value;
    document.getElementById('sort_selected_text').textContent = text;
    
    // Remove selected class from all options
    document.querySelectorAll('#sort-dropdown .custom-select-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    event.target.closest('.custom-select-option').classList.add('selected');
    
    // Close dropdown
    document.getElementById('sort-dropdown').classList.remove('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select-wrapper')) {
        const dropdown = document.getElementById('sort-dropdown');
        if (dropdown) {
            dropdown.classList.remove('active');
        }
    }
});
</script>
@endsection
