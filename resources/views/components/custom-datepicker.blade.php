@props(['name', 'id', 'value' => '', 'label' => '', 'placeholder' => 'Izaberite datum'])

<div class="w-full">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    <div class="relative">
        <input 
            type="text" 
            name="{{ $name }}" 
            id="{{ $id }}" 
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            class="datepicker-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white transition-all cursor-pointer hover:border-gray-400"
        >
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    </div>
</div>
