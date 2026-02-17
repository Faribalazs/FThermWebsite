@props([
    'name',
    'id',
    'selected' => '',
    'selectedText' => '',
    'options' => [],
    'label' => '',
    'placeholder' => 'Izaberite opciju',
    'class' => '',
])

<div class="{{ $class }}">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    
    <div class="custom-select-wrapper">
        <input type="hidden" name="{{ $name }}" id="{{ $id }}_value" value="{{ $selected }}">
        <div class="custom-select-trigger" onclick="toggleCustomDropdown('{{ $id }}')">
            <span class="custom-select-value text-sm sm:text-base" id="{{ $id }}_text">
                {{ $selectedText ?: $placeholder }}
            </span>
            <svg class="custom-select-arrow w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div class="custom-select-dropdown" id="{{ $id }}_dropdown">
            <div class="custom-select-options">
                @foreach($options as $value => $text)
                    <div class="custom-select-option {{ $selected == $value ? 'selected' : '' }}" 
                         onclick="selectCustomOption('{{ $id }}', '{{ $value }}', '{{ $text }}')">
                        <div class="flex items-center justify-between">
                            <span>{{ $text }}</span>
                            @if($selected == $value)
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

@once
@push('scripts')
<script>
// Global custom dropdown functions
window.customDropdownState = window.customDropdownState || {};

function toggleCustomDropdown(id) {
    const dropdown = document.getElementById(id + '_dropdown');
    const isActive = dropdown.classList.contains('active');
    
    // Close all other dropdowns
    document.querySelectorAll('.custom-select-dropdown.active').forEach(dd => {
        dd.classList.remove('active');
    });
    
    // Toggle current dropdown
    if (!isActive) {
        dropdown.classList.add('active');
    }
}

function selectCustomOption(id, value, text) {
    document.getElementById(id + '_value').value = value;
    document.getElementById(id + '_text').textContent = text;
    
    // Remove selected class from all options in this dropdown
    const dropdown = document.getElementById(id + '_dropdown');
    dropdown.querySelectorAll('.custom-select-option').forEach(opt => {
        opt.classList.remove('selected');
        // Remove checkmark
        const checkmark = opt.querySelector('svg');
        if (checkmark) checkmark.remove();
    });
    
    // Add selected class and checkmark to clicked option
    const clickedOption = event.target.closest('.custom-select-option');
    clickedOption.classList.add('selected');
    clickedOption.querySelector('div').insertAdjacentHTML('beforeend', '<svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>');
    
    // Close dropdown
    dropdown.classList.remove('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select-wrapper')) {
        document.querySelectorAll('.custom-select-dropdown.active').forEach(dd => {
            dd.classList.remove('active');
        });
    }
});
</script>
@endpush
@endonce
