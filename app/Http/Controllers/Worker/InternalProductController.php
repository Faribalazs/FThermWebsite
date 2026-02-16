<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use Illuminate\Http\Request;

class InternalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalProduct::query();
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);
        
        return view('worker.products.index', compact('products'));
    }

    public function create()
    {
        return view('worker.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        InternalProduct::create([
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'price' => $validated['price'],
            'low_stock_threshold' => $validated['low_stock_threshold'],
            'created_by' => auth('worker')->id(),
        ]);

        return redirect()->route('worker.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(InternalProduct $product)
    {
        return view('worker.products.edit', compact('product'));
    }

    public function update(Request $request, InternalProduct $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('worker.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(InternalProduct $product)
    {
        $product->delete();
        return redirect()->route('worker.products.index')->with('success', 'Product deleted successfully.');
    }
}
