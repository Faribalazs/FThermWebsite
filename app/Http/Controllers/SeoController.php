<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $locales = ['sr', 'en', 'hu'];
        $urls = [];

        foreach ($locales as $locale) {
            foreach (['', '/about', '/shop', '/references'] as $path) {
                $urls[] = ['loc' => url("/{$locale}{$path}"), 'priority' => $path === '' ? '1.0' : '0.8'];
            }

            foreach (Service::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $service) {
                $urls[] = ['loc' => url("/{$locale}/services/{$service->slug}"), 'lastmod' => $service->updated_at?->toAtomString(), 'priority' => '0.9'];
            }
            foreach (Product::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $product) {
                $urls[] = ['loc' => url("/{$locale}/shop/{$product->slug}"), 'lastmod' => $product->updated_at?->toAtomString(), 'priority' => '0.7'];
            }
            foreach (GalleryAlbum::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $album) {
                $urls[] = ['loc' => url("/{$locale}/references/{$album->slug}"), 'lastmod' => $album->updated_at?->toAtomString(), 'priority' => '0.6'];
            }
        }

        return response()->view('seo.sitemap', compact('urls'))->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function llms(): Response
    {
        $services = Service::where('active', true)->orderBy('order')->get();

        return response()->view('seo.llms', compact('services'))->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
