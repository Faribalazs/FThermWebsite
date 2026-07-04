<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use App\Models\HomepageContent;
use App\Models\Slide;
use App\Models\GalleryAlbum;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->orderBy('order')->get();
        $shopEnabled = shop_enabled();
        $featured_products = $shopEnabled
            ? Product::where('active', true)->orderBy('order')->take(6)->get()
            : collect();
        $hero = HomepageContent::whereIn('key', ['hero_title', 'hero_subtitle', 'hero_cta'])->get()->keyBy('key');
        $slides = Slide::where('active', true)->orderBy('order')->get();
        $galleryAlbums = GalleryAlbum::where('active', true)
            ->with(['images' => fn ($query) => $query->orderBy('order')->limit(1)])
            ->orderBy('order')
            ->take(3)
            ->get();
        $faqItems = Faq::where('active', true)->orderBy('order')->get();

        return view('home', compact('services', 'featured_products', 'hero', 'slides', 'shopEnabled', 'galleryAlbums', 'faqItems'));
    }
}
