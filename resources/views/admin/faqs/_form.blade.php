@php
    $faq = $faq ?? null;
    $isEdit = filled($faq);
    $questions = $faq?->question ?? [];
    $answers = $faq?->answer ?? [];
    $languages = [
        'sr' => ['label' => 'Srpski', 'flag' => '🇷🇸'],
        'en' => ['label' => 'English', 'flag' => '🇬🇧'],
        'hu' => ['label' => 'Magyar', 'flag' => '🇭🇺'],
    ];
@endphp

<form action="{{ $isEdit ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isEdit ? 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' : 'M12 6v6m0 0v6m0-6h6m-6 0H6' }}" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-white">{{ $isEdit ? 'Izmeni pitanje' : 'Novo pitanje' }}</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5">Pitanje i odgovor za sekciju Česta pitanja na svim jezicima</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" x-data="{ langTab: 'sr' }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Sadržaj pitanja</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Unesite pitanje i odgovor za svaki jezik</p>
            </div>

            <div class="flex border-b border-gray-200 px-4 sm:px-6 overflow-x-auto">
                @foreach ($languages as $locale => $language)
                    <button type="button" @click="langTab = '{{ $locale }}'" :class="langTab === '{{ $locale }}' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200 whitespace-nowrap">
                        <span class="text-base">{{ $language['flag'] }}</span> {{ $language['label'] }}
                    </button>
                @endforeach
            </div>

            <div class="p-4 sm:p-6">
                @foreach ($languages as $locale => $language)
                    <div x-show="langTab === '{{ $locale }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-1" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="space-y-5">
                            <div>
                                <label for="question_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Pitanje {{ $language['label'] }} <span class="text-red-500">*</span></label>
                                <input type="text" id="question_{{ $locale }}" name="question_{{ $locale }}" required value="{{ old('question_'.$locale, $questions[$locale] ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                @error('question_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="answer_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Odgovor <span class="text-red-500">*</span></label>
                                <textarea id="answer_{{ $locale }}" name="answer_{{ $locale }}" rows="8" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm leading-7 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">{{ old('answer_'.$locale, $answers[$locale] ?? '') }}</textarea>
                                @error('answer_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h2 class="text-sm sm:text-base font-bold text-gray-900">Prikaz</h2>
                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Redosled i vidljivost na sajtu</p>
                </div>

                <div class="p-4 sm:p-6 space-y-5">
                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-1.5">Redosled <span class="text-red-500">*</span></label>
                        <input type="number" id="order" name="order" required value="{{ old('order', $faq->order ?? 0) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        @error('order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-gray-700">Aktivno pitanje</p>
                            <p class="text-xs text-gray-500 mt-0.5">Vidljivo u sekciji Česta pitanja</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" {{ old('active', $faq->active ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3">
                <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ $isEdit ? 'Sačuvaj izmene' : 'Kreiraj pitanje' }}
                </button>
            </div>
        </aside>
    </div>
</form>
