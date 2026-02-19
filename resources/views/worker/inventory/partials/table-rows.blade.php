@foreach($products as $product)
<tr class="hover:bg-gray-50" id="product-{{ $product->id }}">
    <td class="px-3 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center gap-2 sm:gap-3">
            <div>
                <div class="text-xs sm:text-sm font-bold text-gray-900">{{ $product->name }}</div>            </div>
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
            $quantity = $product->warehouse_inventory->quantity ?? 0;
            $statusClass = $quantity == 0 ? 'bg-red-100 text-red-800' : ($quantity < ($product->low_stock_threshold ?? 10) ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
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
                    class="inline-flex items-center gap-1 px-2 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white text-xs sm:text-sm font-semibold rounded-lg shadow-md">
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="hidden sm:inline">Dodaj</span>
            </button>
        </div>
    </td>
</tr>
@endforeach
@if($products->isEmpty())
<tr>
    <td colspan="5" class="px-6 py-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Nema pronađenih materijala</h3>
        <p class="text-gray-500">Pokušajte sa drugačijom pretragom</p>
    </td>
</tr>
@endif
