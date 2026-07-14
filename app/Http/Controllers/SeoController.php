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

        $addUrl = function (string $path, string $priority, ?string $lastmod = null) use (&$urls, $locales): void {
            $alternates = collect($locales)
                ->mapWithKeys(fn (string $locale) => [$locale => url("/{$locale}{$path}")])
                ->all();

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => $alternates[$locale],
                    'alternates' => $alternates,
                    'lastmod' => $lastmod,
                    'priority' => $priority,
                ];
            }
        };

        $staticPaths = ['', '/about', '/references'];
        if (shop_enabled()) {
            $staticPaths[] = '/shop';
        }

        foreach ($staticPaths as $path) {
            $addUrl($path, $path === '' ? '1.0' : '0.8');
        }

        foreach (['/klime-subotica', '/toplotne-pumpe-subotica'] as $localPath) {
            $addUrl($localPath, '0.95');
        }

        foreach (Service::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $service) {
            $addUrl("/services/{$service->slug}", '0.9', $service->updated_at?->toAtomString());
        }
        if (shop_enabled()) {
            foreach (Product::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $product) {
                $addUrl("/shop/{$product->slug}", '0.7', $product->updated_at?->toAtomString());
            }
        }
        foreach (GalleryAlbum::where('active', true)->orderBy('order')->get(['slug', 'updated_at']) as $album) {
            $addUrl("/references/{$album->slug}", '0.6', $album->updated_at?->toAtomString());
        }

        return response()->view('seo.sitemap', compact('urls'))->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function llms(): Response
    {
        $services = Service::where('active', true)->orderBy('order')->get();
        $shopEnabled = shop_enabled();

        return response()->view('seo.llms', compact('services', 'shopEnabled'))->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
