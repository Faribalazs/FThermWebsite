<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use App\Models\HomepageContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->orderBy('order')->get();
        $featured_products = Product::where('active', true)->orderBy('order')->take(6)->get();
        $hero = HomepageContent::whereIn('key', ['hero_title', 'hero_subtitle', 'hero_cta'])->get()->keyBy('key');

        return view('home', compact('services', 'featured_products', 'hero'));
    }
}
