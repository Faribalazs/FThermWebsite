@extends('layouts.admin')

@section('title', 'Podešavanja kataloga')

@section('content')
<div class="animate-fade-in-up">
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Podešavanja kataloga</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upravljajte javnim prikazom shop dela sajta</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
                    </svg>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900">Shop na sajtu</h3>
                </div>
            </div>

            <form action="{{ route('admin.catalog-settings.update') }}" method="POST" id="catalogSettingsForm">
                @csrf
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Kada je isključeno, posetioci neće videti linkove ka proizvodima i shop stranice neće biti dostupne.
                            </p>
                            <div class="mt-3 flex items-center gap-2" id="shopStatusBadge">
                                <span class="w-2 h-2 rounded-full" id="shopStatusDot"></span>
                                <span class="text-xs font-bold tracking-wider uppercase" id="shopStatusText"></span>
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            <label for="shopEnabledToggle" class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="hidden" name="shop_enabled" value="false">
                                <input type="checkbox"
                                       id="shopEnabledToggle"
                                       name="shop_enabled"
                                       value="true"
                                       class="sr-only peer"
                                       {{ $shopEnabled ? 'checked' : '' }}
                                       onchange="handleShopToggle(this)">
                                <div class="w-14 h-7 bg-gray-200 peer-focus-visible:ring-4 peer-focus-visible:ring-primary-300 rounded-full peer-checked:bg-gradient-to-r peer-checked:from-primary-500 peer-checked:to-primary-600 shadow-inner transition-all duration-300 ease-in-out"></div>
                                <div class="switch-knob absolute top-[3px] left-[3px] bg-white border border-gray-100 rounded-full h-[22px] w-[22px] shadow-md transition-all duration-300 flex items-center justify-center">
                                    <svg class="icon-off w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <svg class="icon-on w-3 h-3 text-primary-600 absolute opacity-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-5 p-3 sm:p-4 rounded-xl bg-blue-50 border border-blue-200">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-blue-800 font-medium">Napomena</p>
                                <p class="text-xs text-blue-700 mt-0.5">Admin stranice za kategorije i proizvode ostaju dostupne, čak i kada je javni shop isključen.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <noscript>
                    <div class="px-4 sm:px-6 pb-4 sm:pb-6">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold hover:from-primary-700 hover:to-primary-800 shadow-lg transition-all text-sm">
                            Sačuvaj
                        </button>
                    </div>
                </noscript>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<style>
    #shopEnabledToggle:checked ~ .switch-knob {
        transform: translateX(28px);
        border-color: #ffffff;
    }
    #shopEnabledToggle:checked ~ .switch-knob .icon-off {
        opacity: 0;
        transform: rotate(90deg) scale(0.5);
    }
    #shopEnabledToggle:checked ~ .switch-knob .icon-on {
        opacity: 1;
        transform: rotate(0deg) scale(1);
    }
    .icon-off,
    .icon-on {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-origin: center;
    }
    .icon-off {
        transform: rotate(0deg) scale(1);
    }
    .icon-on {
        transform: rotate(-90deg) scale(0.5);
    }
</style>

<script>
    function updateShopStatusBadge(isActive) {
        const badge = document.getElementById('shopStatusBadge');
        const dot = document.getElementById('shopStatusDot');
        const text = document.getElementById('shopStatusText');

        if (isActive) {
            badge.className = 'mt-3 flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 w-fit transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
            text.className = 'text-xs font-bold tracking-wider uppercase text-green-700';
            text.textContent = 'SHOP UKLJUČEN';
        } else {
            badge.className = 'mt-3 flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 w-fit transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-gray-400';
            text.className = 'text-xs font-bold tracking-wider uppercase text-gray-600';
            text.textContent = 'SHOP ISKLJUČEN';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateShopStatusBadge(document.getElementById('shopEnabledToggle').checked);
    });

    function handleShopToggle(checkbox) {
        updateShopStatusBadge(checkbox.checked);
        setTimeout(() => { document.getElementById('catalogSettingsForm').submit(); }, 400);
    }
</script>
@endpush
@endsection
