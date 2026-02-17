<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class InternalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalProduct::with('inventory');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);
        
        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('worker.products.partials.table-rows', compact('products'))->render(),
                'pagination' => $products->links()->render()
            ]);
        }
        
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

        $product = InternalProduct::create([
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'price' => $validated['price'],
            'low_stock_threshold' => $validated['low_stock_threshold'],
            'created_by' => auth('worker')->id(),
        ]);

        // Log activity
        ActivityLog::log(
            auth('worker')->id(),
            'create',
            'product',
            $product->id,
            "Kreirao novi materijal: {$product->name}",
            $validated
        );

        return redirect()->route('worker.products.index')->with('success', 'Materijal uspešno kreiran.');
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

        $oldData = $product->toArray();
        $product->update($validated);

        // Log activity
        ActivityLog::log(
            auth('worker')->id(),
            'update',
            'product',
            $product->id,
            "Ažurirao materijal: {$product->name}",
            ['old' => $oldData, 'new' => $validated]
        );

        return redirect()->route('worker.products.index')->with('success', 'Materijal uspešno ažuriran.');
    }

    public function destroy(InternalProduct $product)
    {
        $productName = $product->name;
        $productId = $product->id;
        
        // Log activity before deletion
        ActivityLog::log(
            auth('worker')->id(),
            'delete',
            'product',
            $productId,
            "Obrisao materijal: {$productName}",
            $product->toArray()
        );
        
        $product->delete();
        return redirect()->route('worker.products.index')->with('success', 'Materijal uspešno obrisan.');
    }
}
