@forelse ($products as $product)
<tr class="hover:bg-gray-50 transition-all">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="ml-4">
                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ $product->unit }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-bold text-gray-900">{{ number_format($product->price, 2) }} RSD</div>
    </td>
    <td class="px-6 py-4 text-center">
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
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium {{ $product->low_stock_threshold <= 10 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
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
            <form action="{{ route('worker.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj materijal?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all action-btn">
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
            <p class="text-gray-500 text-lg font-medium">Nema pronađenih materijala</p>
            <p class="text-gray-400 text-sm mt-1">Pokušajte sa drugačijom pretragom</p>
        </div>
    </td>
</tr>
@endforelse
