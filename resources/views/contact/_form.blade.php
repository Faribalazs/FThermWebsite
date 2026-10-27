@php $serviceTypes = __('ftherm.contact.service_types'); @endphp

<form action="{{ route('contact.store') }}" method="POST"
    class="quote-form contact-form-shell grid gap-5 p-5 pt-8 sm:p-7 sm:pt-9">
    @csrf
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name"
                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.name') }}
                *</label>
            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}"
                required
                class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
            @error('name')
                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="city"
                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.city') }}</label>
            <input id="city" name="city" type="text" autocomplete="address-level2" value="{{ old('city') }}"
                class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
            @error('city')
                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="phone"
                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.phone') }}
                *</label>
            <input id="phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}"
                required
                class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
            @error('phone')
                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email"
                class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.email') }}</label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                class="h-14 w-full rounded border-slate-300 px-4 text-base focus:border-sky-500 focus:ring-sky-500">
            @error('email')
                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @php
        $selectedServiceType = old('service_type', '');
        $selectedServiceTypeLabel =
            $selectedServiceType && isset($serviceTypes[$selectedServiceType])
                ? $serviceTypes[$selectedServiceType]
                : __('ftherm.contact.service_type');
    @endphp
    <div>
        <label for="service_type"
            class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.service_type') }}</label>
        <div class="relative" x-data="{ open: false, selected: @js($selectedServiceType), selectedLabel: @js($selectedServiceTypeLabel), choose(value, label) { this.selected = value;
                this.selectedLabel = label;
                this.open = false; } }" @keydown.escape.window="open = false">
            <input id="service_type" name="service_type" type="hidden" x-model="selected">
            <button type="button" @click="open = !open"
                class="flex h-14 w-full items-center justify-between gap-3 rounded border border-slate-300 bg-[#f8fbff] px-4 text-left text-base transition focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-700/10"
                :class="open ? 'border-sky-600 ring-4 ring-sky-700/10' : ''" aria-haspopup="listbox"
                :aria-expanded="open.toString()">
                <span class="min-w-0 truncate"
                    :class="selected ? 'text-slate-950 font-bold' : 'text-slate-500'"
                    x-text="selectedLabel"></span>
                <span
                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded bg-white text-sky-700 shadow-sm">
                    <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>
            <div x-cloak x-show="open" x-transition @click.outside="open = false"
                class="custom-service-menu absolute left-0 right-0 z-30 mt-2 max-h-72 overflow-y-auto p-2"
                role="listbox">
                <button type="button" @click="choose('', @js(__('ftherm.contact.service_type')))"
                    class="custom-service-option flex w-full items-center justify-between rounded px-3 py-3 text-left text-sm font-bold text-slate-500 hover:bg-slate-50">
                    {{ __('ftherm.contact.service_type') }}
                </button>
                @foreach ($serviceTypes as $value => $label)
                    <button type="button"
                        @click="choose(@js($value), @js($label))"
                        class="custom-service-option flex w-full items-center justify-between gap-3 rounded px-3 py-3 text-left text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-800"
                        :class="selected === @js($value) ? 'bg-sky-50 text-sky-800' : ''"
                        role="option"
                        :aria-selected="(selected === @js($value)).toString()">
                        <span>{{ $label }}</span>
                        <svg x-show="selected === @js($value)" x-cloak
                            class="h-4 w-4 flex-shrink-0 text-[#DD2131]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>
        @error('service_type')
            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="message"
            class="mb-2 block text-sm font-black text-slate-800">{{ __('ftherm.contact.message') }}
            *</label>
        <textarea id="message" name="message" rows="6" required
            class="w-full rounded border-slate-300 px-4 py-3 text-base focus:border-sky-500 focus:ring-sky-500">{{ old('message') }}</textarea>
        @error('message')
            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
        class="ft-btn ft-btn-blue inline-flex justify-center px-6 py-4 text-base font-black text-white">{{ __('ftherm.contact.send') }}</button>
</form>
