<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class GalleryVideoController extends Controller
{
    public function store(Request $request, GalleryAlbum $gallery)
    {
        $validated = $request->validate([
            'video' => ['required', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
            'video_caption' => ['nullable', 'string', 'max:255'],
        ], [
            'video.required' => 'Izaberite video za otpremanje.',
            'video.uploaded' => 'Video nije otpremljen. Proverite veličinu datoteke i pokušajte ponovo.',
            'video.mimetypes' => 'Izaberite MP4 ili WebM video.',
            'video.max' => 'Video može imati najviše 50 MB.',
        ]);

        $file = $request->file('video');
        $mime = $file->getMimeType();
        $extension = $mime === 'video/webm' ? 'webm' : 'mp4';
        $path = $file->storeAs('gallery/'.$gallery->id.'/videos', Str::uuid().'.'.$extension, 'public');

        if ($path === false) {
            throw new RuntimeException('The uploaded video could not be stored.');
        }

        try {
            $gallery->videos()->create([
                'path' => $path,
                'mime_type' => $mime,
                'caption' => $validated['video_caption'] ?? null,
                'order' => ($gallery->videos()->max('order') ?? 0) + 1,
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($path);
            throw $exception;
        }

        return to_route('admin.gallery.edit', $gallery)->with('success', 'Video je uspešno otpremljen.');
    }

    public function destroy(GalleryAlbum $gallery, GalleryVideo $video)
    {
        abort_unless($video->album_id === $gallery->id, 404);
        Storage::disk('public')->delete($video->path);
        $video->delete();

        return to_route('admin.gallery.edit', $gallery)->with('success', 'Video je obrisan.');
    }
}
