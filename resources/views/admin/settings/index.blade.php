@extends('layouts.admin')

@section('title', 'Podešavanja')

@section('content')
<div class="animate-fade-in-up">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Sistemska Podešavanja</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upravljajte podešavanjima vašeg sajta</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Maintenance Mode Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900">Režim održavanja</h3>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
                @csrf
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Kada je uključen, sajt će biti nedostupan za javnost. Administratori i radnici i dalje imaju pristup.
                            </p>
                            <div class="mt-3 flex items-center gap-2" id="statusBadge">
                                <span class="w-2 h-2 rounded-full animate-pulse" id="statusDot"></span>
                                <span class="text-xs font-bold tracking-wider uppercase" id="statusText"></span>
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            <label for="maintenanceToggle" class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="hidden" name="maintenance_mode" value="false">
                                <input type="checkbox"
                                       id="maintenanceToggle"
                                       name="maintenance_mode"
                                       value="true"
                                       class="sr-only peer"
                                       {{ $maintenanceMode === 'true' ? 'checked' : '' }}
                                       onchange="handleToggle(this)">
                                <!-- Track -->
                                <div class="w-14 h-7 bg-gray-200 peer-focus-visible:ring-4 peer-focus-visible:ring-primary-300 rounded-full peer-checked:bg-gradient-to-r peer-checked:from-primary-500 peer-checked:to-primary-600 shadow-inner transition-all duration-300 ease-in-out"></div>
                                <!-- Knob -->
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

                    <!-- Info banner -->
                    <div class="mt-5 p-3 sm:p-4 rounded-xl bg-amber-50 border border-amber-200" id="maintenanceInfo">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-amber-800 font-medium">Napomena</p>
                                <p class="text-xs text-amber-700 mt-0.5">Posetilac će videti stranicu za održavanje dok je ovaj režim aktivan. Vaš tim može nastaviti da radi normalno.</p>
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
    #maintenanceToggle:checked ~ .switch-knob {
        transform: translateX(28px);
        border-color: #ffffff;
    }
    #maintenanceToggle:checked ~ .switch-knob .icon-off {
        opacity: 0;
        transform: rotate(90deg) scale(0.5);
    }
    #maintenanceToggle:checked ~ .switch-knob .icon-on {
        opacity: 1;
        transform: rotate(0deg) scale(1);
    }
    .icon-off {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: rotate(0deg) scale(1);
        transform-origin: center;
    }
    .icon-on {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: rotate(-90deg) scale(0.5);
        transform-origin: center;
    }
</style>

<script>
    function updateStatusBadge(isActive) {
        const badge = document.getElementById('statusBadge');
        const dot = document.getElementById('statusDot');
        const text = document.getElementById('statusText');

        if (isActive) {
            badge.className = 'mt-3 flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 w-fit transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
            text.className = 'text-xs font-bold tracking-wider uppercase text-green-700';
            text.textContent = 'UKLJUČENO';
        } else {
            badge.className = 'mt-3 flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 w-fit transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-gray-400';
            text.className = 'text-xs font-bold tracking-wider uppercase text-gray-600';
            text.textContent = 'ISKLJUČENO';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateStatusBadge(document.getElementById('maintenanceToggle').checked);
    });

    function handleToggle(checkbox) {
        updateStatusBadge(checkbox.checked);
        setTimeout(() => { document.getElementById('settingsForm').submit(); }, 400);
    }
</script>
@endpush
@endsection
