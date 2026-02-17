@extends('layouts.worker')

@section('title', 'Pregled Radnog Naloga')

@section('content')
<div class="p-3 sm:p-6 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600">
            <li><a href="{{ route('worker.work-orders.index') }}" class="hover:text-primary-600 transition">Radni Nalozi</a></li>
            <li><svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
            <li class="text-gray-900 font-medium">Pregled</li>
        </ol>
    </nav>

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

    <!-- Work Order Card -->
    <div class="bg-white rounded-xl shadow-enhanced overflow-hidden border border-gray-100 animate-scale-in">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <div class="text-white">
                    <p class="text-xs sm:text-sm opacity-90">Radni Nalog</p>
                    <h1 class="text-xl sm:text-3xl font-bold mt-1">{{ $workOrder->client_name }}</h1>
                    <p class="text-xs sm:text-sm opacity-90 mt-1 sm:mt-2">{{ $workOrder->location }}</p>
                </div>
                @if ($workOrder->has_invoice)
                <span class="bg-green-500 text-white text-xs sm:text-sm font-semibold px-3 sm:px-4 py-1.5 sm:py-2 rounded-full whitespace-nowrap">
                    Fakturisano
                </span>
                @endif
            </div>
        </div>

        <!-- Info -->
        <div class="p-3 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6 mb-6 sm:mb-8">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Datum kreiranja</p>
                    <p class="text-sm sm:text-lg font-semibold">{{ $workOrder->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Status</p>
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $workOrder->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($workOrder->status) }}
                    </span>
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
                @foreach ($workOrder->sections as $section)
                <div class="border border-gray-200 rounded-lg p-3 sm:p-6 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 sm:gap-0 mb-3 sm:mb-4">
                        <h2 class="text-base sm:text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $section->title }}
                        </h2>
                        @if($section->hours_spent)
                        <div class="flex items-center gap-1 sm:gap-2 bg-blue-100 px-2 sm:px-3 py-1 rounded-full">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-800 font-semibold text-xs sm:text-sm">{{ number_format($section->hours_spent, 2) }}h</span>
                        </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Proizvod</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">J. Cena</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Kol.</th>
                                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-right text-xs font-bold text-gray-700 uppercase whitespace-nowrap">Ukupno</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($section->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}
                                            <span class="text-gray-500 text-xs ml-1">({{ $item->product->unit }})</span>
                                        </td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600 whitespace-nowrap">{{ number_format($item->price_at_time, 2) }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-bold text-gray-900 text-right whitespace-nowrap">{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="border-t-2 border-gray-300 pt-4 sm:pt-6 space-y-3 sm:space-y-4">
                <div class="flex justify-between items-center gap-2">
                    <span class="text-sm sm:text-lg font-semibold text-gray-700">Ukupno Materijal:</span>
                    <span class="text-sm sm:text-lg font-bold text-gray-900 whitespace-nowrap">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                </div>
                
                @if($workOrder->hourly_rate && $workOrder->calculateTotalHours() > 0)
                <div class="flex justify-between items-center gap-2">
                    <span class="text-xs sm:text-lg font-semibold text-gray-700">
                        Cena po satu: {{ number_format($workOrder->hourly_rate, 2) }} RSD &times; {{ number_format($workOrder->calculateTotalHours(), 2) }}h
                    </span>
                    <span class="text-sm sm:text-lg font-bold text-gray-900 whitespace-nowrap">{{ number_format($workOrder->calculateLaborCost(), 2) }} RSD</span>
                </div>
                
                <div class="border-t border-gray-300 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-base sm:text-xl font-semibold text-gray-700">Ukupan Iznos:</span>
                        <span class="text-xl sm:text-4xl font-bold text-primary-600 whitespace-nowrap">{{ number_format($workOrder->calculateGrandTotal(), 2) }} RSD</span>
                    </div>
                </div>
                @else
                <div class="border-t border-gray-300 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-base sm:text-xl font-semibold text-gray-700">Ukupan Iznos:</span>
                        <span class="text-xl sm:text-4xl font-bold text-primary-600 whitespace-nowrap">{{ number_format($workOrder->total_amount, 2) }} RSD</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                <a href="{{ route('worker.work-orders.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Nazad
                </a>

                @if (!$workOrder->has_invoice)
                <button type="button" onclick="openInvoiceModal()" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generiši Fakturu
                </button>
                @else
                <a href="{{ route('worker.work-orders.invoice', $workOrder) }}" class="btn-gradient inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Pregled Fakture
                </a>
                @endif

                <form action="{{ route('worker.work-orders.destroy', $workOrder) }}" method="POST" class="sm:ml-auto delete-work-order-form" data-work-order-client="{{ $workOrder->client_name }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="delete-work-order-btn inline-flex items-center justify-center gap-2 w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Obriši
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Modal -->
<div id="invoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-3 sm:p-4" onclick="if(event.target === this) closeInvoiceModal()">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full animate-scale-in max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-t-xl sticky top-0 z-10">
            <h2 class="text-lg sm:text-2xl font-bold text-white">Generiši Fakturu</h2>
        </div>

        <form action="{{ route('worker.work-orders.invoice.generate', $workOrder) }}" method="POST" class="p-4 sm:p-6">
            @csrf

            <div class="mb-4 sm:mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 sm:mb-3">Tip Klijenta *</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <label class="flex items-center p-3 sm:p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition-colors">
                        <input type="radio" name="invoice_type" value="fizicko_lice" class="mr-2 sm:mr-3" required onchange="togglePIBField(false)">
                        <div>
                            <p class="text-sm sm:text-base font-semibold">Fizičko Lice</p>
                            <p class="text-xs text-gray-500">Privatna osoba</p>
                        </div>
                    </label>
                    <label class="flex items-center p-3 sm:p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition-colors">
                        <input type="radio" name="invoice_type" value="pravno_lice" class="mr-2 sm:mr-3" required onchange="togglePIBField(true)">
                        <div>
                            <p class="text-sm sm:text-base font-semibold">Pravno Lice</p>
                            <p class="text-xs text-gray-500">Firma/Preduzeće</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Ime/Naziv *</label>
                    <input type="text" name="invoice_company_name" class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                <div id="pibField" class="hidden">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">PIB</label>
                    <input type="text" name="invoice_pib" class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Adresa *</label>
                    <input type="text" name="invoice_address" class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Email</label>
                        <input type="email" name="invoice_email" class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Telefon</label>
                        <input type="text" name="invoice_phone" class="form-input w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                <button type="button" onclick="closeInvoiceModal()" class="flex-1 px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Otkaži
                </button>
                <button type="submit" class="flex-1 btn-gradient bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    Generiši
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openInvoiceModal() {
    document.getElementById('invoiceModal').classList.remove('hidden');
    document.getElementById('invoiceModal').classList.add('flex');
}

function closeInvoiceModal() {
    document.getElementById('invoiceModal').classList.add('hidden');
    document.getElementById('invoiceModal').classList.remove('flex');
}

function togglePIBField(show) {
    const pibField = document.getElementById('pibField');
    if (show) {
        pibField.classList.remove('hidden');
    } else {
        pibField.classList.add('hidden');
    }
}

// Delete work order confirmation with SweetAlert2
const deleteBtn = document.querySelector('.delete-work-order-btn');
if (deleteBtn) {
    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-work-order-form');
        const clientName = form.dataset.workOrderClient;
        
        Swal.fire({
            title: 'Da li ste sigurni?',
            html: `<p class="text-gray-600 mt-2">Želite da obrišete radni nalog za klijenta <strong class="text-gray-900">"${clientName}"</strong>?</p><p class="text-red-600 text-sm mt-2">Ova akcija je nepovratna!</p>`,
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
}
</script>
@endsection
