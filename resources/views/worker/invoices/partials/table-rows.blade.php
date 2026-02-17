@foreach($invoices as $invoice)
<tr class="hover:bg-gray-50 transition-colors">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-2">
            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-light-100 to-light-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">{{ $invoice->invoice_number }}</div>
                <div class="text-xs text-gray-500">{{ $invoice->client_name }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <div class="text-sm font-semibold text-gray-900">{{ $invoice->invoice_company_name }}</div>
        @if($invoice->invoice_pib)
        <div class="text-xs text-gray-500">PIB: {{ $invoice->invoice_pib }}</div>
        @endif
    </td>
    <td class="px-6 py-4">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $invoice->location }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $invoice->created_at->format('d.m.Y') }}
        </div>
        <div class="text-xs text-gray-500">{{ $invoice->created_at->format('H:i') }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($invoice->invoice_type == 'fizicko_lice')
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
            Fizičko Lice
        </span>
        @else
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
            Pravno Lice
        </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="text-lg font-bold text-primary-600">{{ number_format($invoice->total_amount, 2) }}</div>
        <div class="text-xs text-gray-500">RSD</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex justify-end gap-2">
            <a href="{{ route('worker.work-orders.show', $invoice) }}" 
               class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
               title="Pregled">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </a>
            <a href="{{ route('worker.work-orders.invoice', $invoice) }}" 
               class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
               title="Faktura">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </a>
            <a href="{{ route('worker.work-orders.invoice.download', $invoice) }}" 
               target="_blank"
               class="inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
               title="Preuzmi PDF">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </a>
        </div>
    </td>
</tr>
@endforeach
@if($invoices->isEmpty())
<tr>
    <td colspan="7" class="px-6 py-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Nema pronađenih faktura</h3>
        <p class="text-gray-500">Pokušajte sa drugačijom pretragom</p>
    </td>
</tr>
@endif
