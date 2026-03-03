<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')->orderBy('order')->paginate(20);
        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_sr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_hu' => 'required|string|max:255',
            'description_sr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_hu' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:gallery_albums,slug',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        GalleryAlbum::create([
            'title' => [
                'sr' => $validated['title_sr'],
                'en' => $validated['title_en'],
                'hu' => $validated['title_hu'],
            ],
            'description' => [
                'sr' => $validated['description_sr'] ?? '',
                'en' => $validated['description_en'] ?? '',
                'hu' => $validated['description_hu'] ?? '',
            ],
            'slug' => $validated['slug'],
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Album uspešno kreiran');
    }

    public function edit(GalleryAlbum $gallery)
    {
        $gallery->load('images');
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryAlbum $gallery)
    {
        $validated = $request->validate([
            'title_sr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_hu' => 'required|string|max:255',
            'description_sr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_hu' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:gallery_albums,slug,' . $gallery->id,
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        $gallery->update([
            'title' => [
                'sr' => $validated['title_sr'],
                'en' => $validated['title_en'],
                'hu' => $validated['title_hu'],
            ],
            'description' => [
                'sr' => $validated['description_sr'] ?? '',
                'en' => $validated['description_en'] ?? '',
                'hu' => $validated['description_hu'] ?? '',
            ],
            'slug' => $validated['slug'],
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.gallery.edit', $gallery)->with('success', 'Album uspešno ažuriran');
    }

    public function destroy(GalleryAlbum $gallery)
    {
        // Delete all stored images from disk
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Album uspešno obrisan');
    }

    public function uploadImage(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        $lastOrder = $gallery->images()->max('order') ?? 0;

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery/' . $gallery->id, 'public');
            $lastOrder++;

            GalleryImage::create([
                'album_id' => $gallery->id,
                'path' => $path,
                'order' => $lastOrder,
            ]);
        }

        return back()->with('success', 'Slike uspešno otpremljene');
    }

    public function deleteImage(GalleryImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Slika uspešno obrisana');
    }

    public function reorderImages(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:gallery_images,id',
        ]);

        foreach ($request->order as $position => $imageId) {
            GalleryImage::where('id', $imageId)
                ->where('album_id', $gallery->id)
                ->update(['order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}
