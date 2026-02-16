@extends('layouts.admin')

@section('title', 'Podešavanja')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold mb-6 text-gray-800 border-b pb-4">Sistemska Podešavanja</h3>

    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf
        
        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-md max-w-4xl">
            <div class="flex-1 pr-8">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-900">Režim održavanja</h4>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Kada je uključen, sajt će biti nedostupan za javnost. Administratori i radnici i dalje imaju pristup.
                </p>
            </div>
            
            <div class="flex flex-col items-center gap-4 min-w-[140px]">
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
                    <div class="w-16 h-8 bg-gray-200 peer-focus-visible:ring-4 peer-focus-visible:ring-primary-300 rounded-full peer-checked:bg-gradient-to-r peer-checked:from-primary-500 peer-checked:to-primary-600 shadow-inner transition-all duration-300 ease-in-out"></div>
                    
                    <!-- Knob with Icons -->
                    <div class="switch-knob absolute top-[4px] left-[4px] bg-white border border-gray-100 rounded-full h-6 w-6 shadow-md transition-all duration-300 flex items-center justify-center">
                        <svg class="icon-off w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <svg class="icon-on w-3.5 h-3.5 text-primary-600 absolute opacity-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </label>
                
                <div class="flex items-center gap-2 px-3 py-1 rounded-full transition-all duration-300" id="statusBadge">
                    <span class="w-2 h-2 rounded-full animate-pulse" id="statusDot"></span>
                    <span class="text-xs font-bold tracking-wider uppercase" id="statusText"></span>
                </div>
            </div>
        </div>
        
        <!-- Button fallback if JS doesn't auto-submit -->
        <noscript>
            <button type="submit" class="mt-4 bg-primary-600 text-white px-6 py-2.5 rounded-lg hover:bg-primary-700 transition-colors shadow-md">
                Sačuvaj
            </button>
        </noscript>
    </form>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Advanced Switch Animation Keyframes */
    #maintenanceToggle:checked ~ .switch-knob {
        transform: translateX(32px); /* 4rem width (64px) - 4px pad - 4px pad - 24px knob = 32px travel */
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
    // Update status badge based on current state
    function updateStatusBadge(isActive) {
        const badge = document.getElementById('statusBadge');
        const dot = document.getElementById('statusDot');
        const text = document.getElementById('statusText');
        
        if (isActive) {
            badge.className = 'flex items-center gap-2 px-4 py-1.5 rounded-full bg-green-100 transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
            text.className = 'text-sm font-semibold text-green-700';
            text.textContent = 'UKLJUČENO';
        } else {
            badge.className = 'flex items-center gap-2 px-4 py-1.5 rounded-full bg-gray-100 transition-all duration-300';
            dot.className = 'w-2 h-2 rounded-full bg-gray-500 animate-pulse';
            text.className = 'text-sm font-semibold text-gray-700';
            text.textContent = 'ISKLJUČENO';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('maintenanceToggle');
        const isChecked = checkbox.checked;

        updateStatusBadge(isChecked);
    });
    
    // Handle toggle change
    function handleToggle(checkbox) {
        const isChecked = checkbox.checked;
        
        updateStatusBadge(isChecked);
        
        // Add a slight delay for visual feedback before submitting
        setTimeout(() => {
            document.getElementById('settingsForm').submit();
        }, 400);
    }
</script>
@endsection
