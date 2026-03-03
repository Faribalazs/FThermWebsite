<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::where('active', true)
            ->withCount('images')
            ->with(['images' => fn ($q) => $q->orderBy('order')->limit(1)])
            ->orderBy('order')
            ->get();

        return view('gallery.index', compact('albums'));
    }

    public function show(string $locale, string $slug)
    {
        $album = GalleryAlbum::where('slug', $slug)
            ->where('active', true)
            ->with(['images' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        return view('gallery.show', compact('album'));
    }
}
