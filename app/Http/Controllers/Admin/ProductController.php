<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('order')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::where('active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name_en' => 'required|string|max:255',
            'name_sr' => 'required|string|max:255',
            'name_hu' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_sr' => 'required|string',
            'description_hu' => 'required|string',
            'technical_specs_en' => 'nullable|string',
            'technical_specs_sr' => 'nullable|string',
            'technical_specs_hu' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:products,slug',
            'price' => 'nullable|numeric|min:0',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        Product::create([
            'category_id' => $validated['category_id'],
            'name' => [
                'en' => $validated['name_en'],
                'sr' => $validated['name_sr'],
                'hu' => $validated['name_hu'],
            ],
            'description' => [
                'en' => $validated['description_en'],
                'sr' => $validated['description_sr'],
                'hu' => $validated['description_hu'],
            ],
            'technical_specs' => [
                'en' => $validated['technical_specs_en'] ?? '',
                'sr' => $validated['technical_specs_sr'] ?? '',
                'hu' => $validated['technical_specs_hu'] ?? '',
            ],
            'slug' => $validated['slug'],
            'price' => $validated['price'] ?? null,
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Proizvod uspešno kreiran');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name_en' => 'required|string|max:255',
            'name_sr' => 'required|string|max:255',
            'name_hu' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_sr' => 'required|string',
            'description_hu' => 'required|string',
            'technical_specs_en' => 'nullable|string',
            'technical_specs_sr' => 'nullable|string',
            'technical_specs_hu' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'price' => 'nullable|numeric|min:0',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => [
                'en' => $validated['name_en'],
                'sr' => $validated['name_sr'],
                'hu' => $validated['name_hu'],
            ],
            'description' => [
                'en' => $validated['description_en'],
                'sr' => $validated['description_sr'],
                'hu' => $validated['description_hu'],
            ],
            'technical_specs' => [
                'en' => $validated['technical_specs_en'] ?? '',
                'sr' => $validated['technical_specs_sr'] ?? '',
                'hu' => $validated['technical_specs_hu'] ?? '',
            ],
            'slug' => $validated['slug'],
            'price' => $validated['price'] ?? null,
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Proizvod uspešno ažuriran');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Proizvod uspešno obrisan');
    }
}
