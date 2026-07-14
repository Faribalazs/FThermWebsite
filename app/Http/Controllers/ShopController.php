<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        if (!shop_enabled()) {
            return $this->gone();
        }

        $query = Product::where('active', true)->with('category', 'primaryImage');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderBy('order')->paginate(12);
        $categories = ProductCategory::where('active', true)->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(string $locale, Product $product)
    {
        if (!shop_enabled()) {
            return $this->gone();
        }

        $product->load('category', 'images');
        $related_products = Product::where('active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'related_products'));
    }

    /**
     * Tell search engines that the disabled catalog and its products were removed.
     */
    private function gone(): Response
    {
        return response('', Response::HTTP_GONE)
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}
