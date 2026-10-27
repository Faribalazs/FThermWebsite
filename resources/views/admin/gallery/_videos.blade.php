<section id="videos" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" aria-labelledby="videos-heading">
    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-200 flex items-center justify-between gap-3">
        <div>
            <h2 id="videos-heading" class="text-base font-bold text-gray-900">Video snimci</h2>
            <p class="text-xs text-gray-500 mt-1">Dodajte video prikaz radova ovoj referenci.</p>
        </div>
        <span class="text-xs font-bold text-gray-400">{{ $gallery->videos->count() }} video</span>
    </div>
    <div class="p-4 sm:p-6">
        <form action="{{ route('admin.gallery.videos.upload', $gallery) }}" method="POST" enctype="multipart/form-data" id="video-upload-form" class="space-y-4 mb-6">
            @csrf
            <div>
                <label for="video-input" class="block text-sm font-bold text-gray-700 mb-2">Izaberite video</label>
                <input id="video-input" name="video" type="file" accept="video/mp4,video/webm,.mp4,.webm" required
                    aria-describedby="video-help video-error"
                    class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-xl file:border-0 file:bg-primary-50 file:px-4 file:py-3 file:font-bold file:text-primary-700">
                <p id="video-help" class="text-xs text-gray-500 mt-2">MP4 ili WebM, najviše 50 MB po videu. Preporučen MP4 (H.264). Otpremite jedan video odjednom.</p>
                <p id="video-error" class="text-sm text-red-600 mt-2" role="alert">{{ $errors->first('video') }}</p>
            </div>
            <div>
                <label for="video-caption" class="block text-sm font-bold text-gray-700 mb-2">Opis videa <span class="font-normal text-gray-400">(opciono)</span></label>
                <input id="video-caption" name="video_caption" type="text" maxlength="255" value="{{ old('video_caption') }}"
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                @error('video_caption') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <p id="video-upload-status" class="text-sm text-gray-500" role="status" aria-live="polite"></p>
            <button type="submit" class="min-h-12 w-full sm:w-auto rounded-xl bg-primary-600 px-5 py-3 text-sm font-bold text-white hover:bg-primary-700 disabled:opacity-50 disabled:cursor-wait">Otpremi video</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($gallery->videos as $video)
                <figure class="min-w-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                    <video controls playsinline preload="none" class="w-full aspect-video bg-gray-900" aria-label="{{ $video->caption ?: 'Video '.$loop->iteration }}">
                        <source src="{{ Storage::url($video->path) }}" type="{{ $video->mime_type }}">
                        Vaš pregledač ne podržava video reprodukciju.
                    </video>
                    <figcaption class="p-4 flex flex-wrap items-center justify-between gap-3">
                        <span class="text-sm font-semibold text-gray-700 break-words">{{ $video->caption ?: 'Video '.$loop->iteration }}</span>
                        <form action="{{ route('admin.gallery.videos.delete', [$gallery, $video]) }}" method="POST" data-confirm="Obrišite ovaj video?" data-type="delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="min-h-11 rounded-lg bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Obriši video</button>
                        </form>
                    </figcaption>
                </figure>
            @empty
                <p class="text-sm text-gray-400">Ova referenca još nema video snimke.</p>
            @endforelse
        </div>
    </div>
</section>
