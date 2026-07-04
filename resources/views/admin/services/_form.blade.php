@php
    $service = $service ?? null;
    $isEdit = filled($service);
    $titles = $service?->title ?? [];
    $descriptions = $service?->description ?? [];
    $contents = $service?->content ?? [];
    $imageAlts = $service?->image_alt ?? [];
    $languages = [
        'sr' => ['label' => 'Srpski', 'flag' => '🇷🇸'],
        'en' => ['label' => 'English', 'flag' => '🇬🇧'],
        'hu' => ['label' => 'Magyar', 'flag' => '🇭🇺'],
    ];
    $imagePreview = $isEdit && $service->image
        ? (str_starts_with($service->image, 'images/') ? asset($service->image) : Storage::url($service->image))
        : null;
@endphp

<form action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
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
                    <h1 class="text-lg sm:text-xl font-bold text-white">{{ $isEdit ? 'Izmeni uslugu' : 'Nova usluga' }}</h1>
                    <p class="text-primary-100 text-xs sm:text-sm mt-0.5">{{ $isEdit ? 'Sadržaj kartice i detaljne stranice usluge' : 'Dodajte novu uslugu i njenu detaljnu stranicu' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" x-data="{ langTab: 'sr' }">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h2 class="text-sm sm:text-base font-bold text-gray-900">Sadržaj usluge</h2>
                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Naziv, kratak opis i detaljan tekst stranice na svim jezicima</p>
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
                                    <label for="title_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv {{ $language['label'] }} <span class="text-red-500">*</span></label>
                                    <input type="text" id="title_{{ $locale }}" name="title_{{ $locale }}" required value="{{ old('title_'.$locale, $titles[$locale] ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('title_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="description_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Kratak opis za karticu <span class="text-red-500">*</span></label>
                                    <textarea id="description_{{ $locale }}" name="description_{{ $locale }}" rows="4" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">{{ old('description_'.$locale, $descriptions[$locale] ?? '') }}</textarea>
                                    @error('description_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="content_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Detaljan sadržaj stranice</label>
                                    <textarea id="content_{{ $locale }}" name="content_{{ $locale }}" rows="12" class="tinymce-editor w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">{{ old('content_'.$locale, $contents[$locale] ?? '') }}</textarea>
                                    @error('content_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="image_alt_{{ $locale }}" class="block text-sm font-bold text-gray-700 mb-1.5">Alt tekst slike</label>
                                    <input type="text" id="image_alt_{{ $locale }}" name="image_alt_{{ $locale }}" value="{{ old('image_alt_'.$locale, $imageAlts[$locale] ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    @error('image_alt_'.$locale) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h2 class="text-sm sm:text-base font-bold text-gray-900">Stranica</h2>
                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">URL, slika i prikaz na sajtu</p>
                </div>

                <div class="p-4 sm:p-6 space-y-5">
                    <div>
                        <label for="slug" class="block text-sm font-bold text-gray-700 mb-1.5">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $service->slug ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" placeholder="npr. toplotne-pumpe">
                        <p class="mt-1.5 text-xs text-gray-400">Ako ostane prazno, biće napravljen iz engleskog naziva.</p>
                        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-1.5">Slika usluge</label>
                        @if ($imagePreview)
                            <img src="{{ $imagePreview }}" alt="" class="mb-3 h-40 w-full rounded-xl object-cover">
                        @endif
                        <input type="file" id="image" name="image" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-primary-700 hover:file:bg-primary-100">
                        @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-1.5">Redosled <span class="text-red-500">*</span></label>
                        <input type="number" id="order" name="order" required value="{{ old('order', $service->order ?? 0) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        @error('order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-gray-700">Aktivna usluga</p>
                            <p class="text-xs text-gray-500 mt-0.5">Vidljiva na sajtu</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" {{ old('active', $service->active ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3">
                <a href="{{ route('admin.services.index') }}" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-5 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ $isEdit ? 'Sačuvaj izmene' : 'Kreiraj uslugu' }}
                </button>
            </div>
        </aside>
    </div>
</form>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '.tinymce-editor',
        height: 420,
        menubar: false,
        plugins: 'lists link code table wordcount fullscreen',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code fullscreen',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 15px; line-height: 1.75; }',
        branding: false,
        promotion: false,
        setup: function(editor) {
            editor.on('change keyup', function() {
                editor.save();
            });
        }
    });
</script>
@endpush
