<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_sr' => 'required|string|max:255',
            'name_hu' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug',
            'active' => 'boolean',
        ]);

        ProductCategory::create([
            'name' => [
                'en' => $validated['name_en'],
                'sr' => $validated['name_sr'],
                'hu' => $validated['name_hu'],
            ],
            'slug' => $validated['slug'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategorija uspešno kreirana');
    }

    public function edit(ProductCategory $product_category)
    {
        $category = $product_category;
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $product_category)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_sr' => 'required|string|max:255',
            'name_hu' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:product_categories,slug,' . $product_category->id,
            'active' => 'boolean',
        ]);

        $product_category->update([
            'name' => [
                'en' => $validated['name_en'],
                'sr' => $validated['name_sr'],
                'hu' => $validated['name_hu'],
            ],
            'slug' => $validated['slug'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategorija uspešno ažurirana');
    }

    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return redirect()->route('admin.product-categories.index')->with('success', 'Kategorija uspešno obrisana');
    }
}
