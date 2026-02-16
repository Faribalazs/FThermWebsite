<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryReplenishmentController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalProduct::with(['inventory', 'creator']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('unit', 'LIKE', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'quantity') {
            $query->leftJoin('inventories', 'internal_products.id', '=', 'inventories.internal_product_id')
                  ->select('internal_products.*', 'inventories.quantity')
                  ->orderBy('inventories.quantity', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(15)->withQueryString();

        return view('worker.inventory.index', compact('products'));
    }

    public function update(Request $request, InternalProduct $product)
    {
        $validated = $request->validate([
            'quantity_to_add' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $inventory = Inventory::firstOrCreate(
                ['internal_product_id' => $product->id],
                ['quantity' => 0, 'updated_by' => auth('worker')->id()]
            );

            $inventory->quantity += $validated['quantity_to_add'];
            $inventory->updated_by = auth('worker')->id();
            $inventory->save();

            DB::commit();

            return redirect()->back()->with('success', "Uspešno dodato {$validated['quantity_to_add']} {$product->unit} u zalihe proizvoda: {$product->name}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function set(Request $request, InternalProduct $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $inventory = Inventory::updateOrCreate(
                ['internal_product_id' => $product->id],
                [
                    'quantity' => $validated['quantity'],
                    'updated_by' => auth('worker')->id()
                ]
            );

            DB::commit();

            return redirect()->back()->with('success', "Količina postavljena na {$validated['quantity']} {$product->unit} za proizvod: {$product->name}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Greška: ' . $e->getMessage());
        }
    }
}
