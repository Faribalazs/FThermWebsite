@props(['name', 'id', 'value' => '', 'label' => '', 'placeholder' => 'Izaberite datum'])

<div class="w-full" x-data="{ hasValue: {{ $value ? 'true' : 'false' }} }">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
            </svg>
        </div>
        <input 
            type="text" 
            name="{{ $name }}" 
            id="{{ $id }}" 
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            readonly
            class="datepicker-input w-full pl-11 pr-10 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white transition-all cursor-pointer hover:border-gray-400 hover:shadow-sm"
            x-on:change="hasValue = ($el.value !== '')"
        >
        {{-- Clear button --}}
        <button 
            type="button" 
            x-show="hasValue" 
            x-cloak
            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-red-500 transition-colors"
            x-on:click.prevent="
                const input = document.getElementById('{{ $id }}');
                if (input._flatpickr) { input._flatpickr.clear(); }
                hasValue = false;
            "
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        {{-- Calendar icon when no value --}}
        <div x-show="!hasValue" class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</div>
