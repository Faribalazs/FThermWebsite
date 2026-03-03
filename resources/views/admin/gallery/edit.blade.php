@extends('layouts.admin')

@section('title', 'Izmeni album')

@section('content')
<div class="animate-fade-in-up">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na galeriju
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-white">{{ $gallery->title['sr'] ?? $gallery->title['en'] ?? 'Album' }}</h1>
                        <p class="text-primary-100 text-xs sm:text-sm mt-0.5">{{ $gallery->images->count() }} {{ $gallery->images->count() === 1 ? 'slika' : 'slika/e' }} u albumu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Translations Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="{ langTab: 'sr' }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Prevodi</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Naziv i opis albuma na svim jezicima</p>
            </div>
            <div class="flex border-b border-gray-200 px-4 sm:px-6">
                @foreach(['sr' => ['flag' => '🇷🇸', 'label' => 'Srpski'], 'en' => ['flag' => '🇬🇧', 'label' => 'English'], 'hu' => ['flag' => '🇭🇺', 'label' => 'Magyar']] as $code => $lang)
                <button type="button" @click="langTab = '{{ $code }}'"
                    :class="langTab === '{{ $code }}' ? 'border-primary-500 text-primary-600 bg-primary-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2.5 sm:py-3 border-b-2 text-xs sm:text-sm font-bold transition-all duration-200">
                    <span class="text-base">{{ $lang['flag'] }}</span> {{ $lang['label'] }}
                </button>
                @endforeach
            </div>
            <div class="p-4 sm:p-6">
                @foreach(['sr' => 'Srpski', 'en' => 'English', 'hu' => 'Magyar'] as $code => $label)
                <div x-show="langTab === '{{ $code }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="space-y-4">
                        <div>
                            <label for="title_{{ $code }}" class="block text-sm font-bold text-gray-700 mb-1.5">Naziv <span class="text-red-500">*</span></label>
                            <input type="text" id="title_{{ $code }}" name="title_{{ $code }}" required
                                value="{{ old('title_' . $code, $gallery->title[$code] ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                            @error('title_' . $code) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description_{{ $code }}" class="block text-sm font-bold text-gray-700 mb-1.5">Opis</label>
                            <textarea id="description_{{ $code }}" name="description_{{ $code }}" rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">{{ old('description_' . $code, $gallery->description[$code] ?? '') }}</textarea>
                            @error('description_' . $code) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Settings Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Podešavanja</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Slug, redosled i vidljivost</p>
            </div>
            <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="slug" class="block text-sm font-bold text-gray-700 mb-1.5">Slug (URL) <span class="text-red-500">*</span></label>
                    <div class="flex items-center">
                        <span class="px-3 py-2.5 bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl text-sm text-gray-500">/galerija/</span>
                        <input type="text" id="slug" name="slug" required value="{{ old('slug', $gallery->slug) }}"
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-r-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                    </div>
                    @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="order" class="block text-sm font-bold text-gray-700 mb-1.5">Redosled <span class="text-red-500">*</span></label>
                    <input type="number" id="order" name="order" required value="{{ old('order', $gallery->order) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                </div>
                <div class="sm:col-span-3">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" {{ $gallery->active ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-checked:bg-primary-600 rounded-full transition-colors duration-200"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-700">Aktivan album</span>
                            <p class="text-[11px] text-gray-400">Prikazati album na sajtu</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save button -->
        <div class="flex flex-col sm:flex-row gap-3 justify-end mb-8">
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all duration-200">
                Otkaži
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-8 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Sačuvaj izmene
            </button>
        </div>
    </form>

    <!-- ─── Images Section ─── -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-gray-900">Slike</h2>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Prevucite da promenite redosled. Kliknite × da obrišete.</p>
            </div>
            <span class="text-xs font-bold text-gray-400">{{ $gallery->images->count() }} slika/e</span>
        </div>

        <div class="p-4 sm:p-6">
            <!-- Upload zone -->
            <form action="{{ route('admin.gallery.images.upload', $gallery) }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div id="drop-zone"
                    class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-primary-400 hover:bg-primary-50/30 transition-all duration-200 cursor-pointer mb-6"
                    onclick="document.getElementById('image-input').click()">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm font-bold text-gray-500">Kliknite ili prevucite slike ovde</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 8 MB po slici</p>
                    <input type="file" id="image-input" name="images[]" multiple accept="image/*" class="hidden">
                </div>

                <!-- Preview before upload -->
                <div id="preview-container" class="hidden mb-4">
                    <p class="text-xs font-bold text-gray-500 mb-3">Pregled pre otpremanja:</p>
                    <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4"></div>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Otpremi slike
                    </button>
                </div>
            </form>

            <!-- Existing Images (sortable) -->
            @if($gallery->images->isNotEmpty())
            <div id="sortable-images" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach($gallery->images as $image)
                <div class="relative group cursor-grab active:cursor-grabbing" data-id="{{ $image->id }}">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                        <img src="{{ Storage::url($image->path) }}" alt="" class="w-full h-full object-cover">
                    </div>
                    <!-- Drag handle overlay -->
                    <div class="absolute inset-0 rounded-xl bg-black/0 group-hover:bg-black/20 transition-all duration-200 flex items-start justify-end p-1.5">
                        <form action="{{ route('admin.gallery.images.delete', $image) }}" method="POST"
                              data-confirm="Obrišite ovu sliku?" data-type="delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600 shadow-lg">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <!-- Order badge -->
                    <span class="absolute bottom-1 left-1 bg-black/60 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md">{{ $loop->iteration }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-6 text-gray-400 text-sm">
                Nema slika. Otpremite prve slike gore.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Image upload preview
    const input = document.getElementById('image-input');
    const previewContainer = document.getElementById('preview-container');
    const previewGrid = document.getElementById('preview-grid');
    const dropZone = document.getElementById('drop-zone');

    function showPreviews(files) {
        previewGrid.innerHTML = '';
        if (!files.length) { previewContainer.classList.add('hidden'); return; }
        previewContainer.classList.remove('hidden');
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'aspect-square rounded-xl overflow-hidden bg-gray-100';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                previewGrid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    input.addEventListener('change', () => showPreviews(input.files));

    // Drag & drop onto drop zone
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-primary-400', 'bg-primary-50/30'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-primary-400', 'bg-primary-50/30'); });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-primary-400', 'bg-primary-50/30');
        const dt = new DataTransfer();
        Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
        input.files = dt.files;
        showPreviews(input.files);
    });

    // Sortable
    const sortableEl = document.getElementById('sortable-images');
    if (sortableEl) {
        Sortable.create(sortableEl, {
            animation: 150,
            ghostClass: 'opacity-30',
            onEnd: function () {
                const ids = Array.from(sortableEl.querySelectorAll('[data-id]')).map(el => el.dataset.id);
                fetch('{{ route('admin.gallery.images.reorder', $gallery) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: ids })
                });
                // Update order badge numbers
                sortableEl.querySelectorAll('[data-id]').forEach((el, idx) => {
                    const badge = el.querySelector('span');
                    if (badge) badge.textContent = idx + 1;
                });
            }
        });
    }

    // Confirm dialogs (same pattern as rest of admin)
    document.querySelectorAll('[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm(this.dataset.confirm)) e.preventDefault();
        });
    });
});
</script>
@endsection
