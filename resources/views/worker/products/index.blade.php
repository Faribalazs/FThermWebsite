@extends('layouts.worker')

@section('title', 'Interni Materijali')

@section('content')
<div class="p-3 sm:p-6 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col gap-3 sm:gap-4">
            <div>
                <h1 class="text-xl sm:text-3xl font-bold text-gray-900 flex items-center gap-2 sm:gap-3">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Interni Materijali
                </h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Upravljajte internim materijalima</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('worker.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 btn-gradient text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Dodaj Materijal
                </a>
                <a href="{{ route('worker.products.export') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Izvezi u Excel
                </a>
                <button type="button" onclick="document.getElementById('import-file-input').click()" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Uvezi iz Excel
                </button>
                <form id="import-form" action="{{ route('worker.products.import') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" id="import-file-input" name="file" accept=".xlsx,.xls,.csv" onchange="document.getElementById('import-form').submit()">
                </form>
            </div>
        </div>
    </div>

    <!-- Success Message -->
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

    <!-- Error Message -->
    @if (session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <span class="text-red-800 font-medium block">{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-2 sm:mb-3">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="product-search" value="{{ request('search') }}" placeholder="Pretraži materijale..." class="pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 w-full text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
            <div id="search-loader" class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center hidden">
                <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Per Page Dropdown -->
    <div class="mb-4 sm:mb-6 sm:flex sm:justify-end">
        <div class="w-full sm:w-44">
            <div class="custom-select-wrapper">
                <input type="hidden" id="per-page-value" value="{{ request('per_page', 10) }}">
                <div class="custom-select-trigger" onclick="togglePerPageDropdown()">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span class="custom-select-value text-xs sm:text-sm" id="per_page_selected_text">
                            {{ request('per_page', 10) }} po stranici
                        </span>
                    </div>
                    <svg class="custom-select-arrow w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="custom-select-dropdown" id="per-page-dropdown">
                    <div class="custom-select-options">
                        @foreach([10, 20, 30, 40, 50, 100] as $option)
                            <div class="custom-select-option {{ request('per_page', 10) == $option ? 'selected' : '' }}" onclick="selectPerPageOption({{ $option }})">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs sm:text-sm">{{ $option }} po stranici</span>
                                    @if(request('per_page', 10) == $option)
                                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
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

    <!-- Products Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 animate-scale-in">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 modern-table">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Naziv
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                Jedinica
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cena (RSD)
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Stanje
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Nizak Limit
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody id="products-table-body" class="bg-white divide-y divide-gray-100">
                    @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $product->unit }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ number_format($product->price, 2) }} RSD</div>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4 text-center">
                            @php
                                $quantity = $product->inventory->quantity ?? 0;
                                $statusClass = $quantity == 0 ? 'bg-red-100 text-red-800' : ($quantity < 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                            @endphp
                            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-bold {{ $statusClass }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $quantity }} {{ $product->unit }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                {{ $product->low_stock_threshold ?? 10 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('worker.products.edit', $product) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-all action-btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Izmeni
                                </a>
                                <form action="{{ route('worker.products.destroy', $product) }}" method="POST" class="inline delete-form" data-product-name="{{ $product->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn inline-flex items-center gap-1 px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all action-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Obriši
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center empty-state">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Nema unetih materijala</p>
                                <p class="text-gray-400 text-sm mt-1">Dodajte prvi materijal klikom na dugme iznad</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div id="pagination-container" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            @if ($products->hasPages())
                {{ $products->links() }}
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
let searchTimeout;
const searchInput = document.getElementById('product-search');
const tableBody = document.getElementById('products-table-body');
const paginationContainer = document.getElementById('pagination-container');
const searchLoader = document.getElementById('search-loader');

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        performSearch(this.value);
    }, 300); // Wait 300ms after user stops typing
});

// Handle pagination clicks
document.addEventListener('click', function(e) {
    if (e.target.closest('#pagination-container a')) {
        e.preventDefault();
        const url = e.target.closest('a').href;
        const searchQuery = searchInput.value;
        const perPage = document.getElementById('per-page-value').value;
        
        // Add search query and per_page to pagination URL if exists
        let fullUrl = url;
        const separator = url.includes('?') ? '&' : '?';
        if (searchQuery) {
            fullUrl += `${separator}search=${encodeURIComponent(searchQuery)}`;
        }
        if (perPage) {
            const nextSeparator = fullUrl.includes('?') ? '&' : '?';
            fullUrl += `${nextSeparator}per_page=${perPage}`;
        }
        fullUrl = fullUrl;
        
        fetchResults(fullUrl);
    }
});

function performSearch(query) {
    const perPage = document.getElementById('per-page-value').value;
    const url = `{{ route('worker.products.index') }}?search=${encodeURIComponent(query)}&per_page=${perPage}`;
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
        
        // Re-attach delete handlers for newly loaded content
        attachDeleteHandlers();
    })
    .catch(error => {
        console.error('Search error:', error);
        searchLoader.classList.add('hidden');
    });
}

// Delete confirmation with SweetAlert2
function attachDeleteHandlers() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            const productName = form.dataset.productName;
            
            Swal.fire({
                title: 'Da li ste sigurni?',
                html: `<p class="text-gray-600 mt-2">Želite da obrišete materijal <strong class="text-gray-900">"${productName}"</strong>?</p>`,
                icon: 'warning',
                iconColor: '#3b82f6',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: '<span class="px-2">Da, obriši!</span>',
                cancelButtonText: '<span class="px-2">Otkaži</span>',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    title: 'text-2xl font-bold text-gray-900',
                    htmlContainer: 'text-base',
                    confirmButton: 'rounded-lg px-6 py-3 font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5',
                    cancelButton: 'rounded-lg px-6 py-3 font-semibold hover:bg-gray-300 transition-all duration-200',
                    actions: 'gap-3',
                    icon: 'border-4 border-blue-100'
                },
                buttonsStyling: true,
                backdrop: 'rgba(0, 0, 0, 0.4)',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
}

// Initial attachment
attachDeleteHandlers();

// Per Page Dropdown Functions
function togglePerPageDropdown() {
    const dropdown = document.getElementById('per-page-dropdown');
    dropdown.classList.toggle('active');
}

function selectPerPageOption(value) {
    document.getElementById('per-page-value').value = value;
    document.getElementById('per_page_selected_text').textContent = value + ' po stranici';
    
    // Remove selected class from all options
    document.querySelectorAll('#per-page-dropdown .custom-select-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    event.target.closest('.custom-select-option').classList.add('selected');
    
    // Close dropdown
    document.getElementById('per-page-dropdown').classList.remove('active');
    
    // Reload with new per_page value
    const searchQuery = searchInput.value;
    const url = `{{ route('worker.products.index') }}?per_page=${value}${searchQuery ? '&search=' + encodeURIComponent(searchQuery) : ''}`;
    fetchResults(url);
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const perPageDropdown = document.getElementById('per-page-dropdown');
    const perPageTrigger = perPageDropdown?.previousElementSibling;
    
    if (perPageDropdown && perPageTrigger && !perPageDropdown.contains(event.target) && !perPageTrigger.contains(event.target)) {
        perPageDropdown.classList.remove('active');
    }
});

</script>
@endpush

@endsection
