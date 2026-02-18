<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryReplenishmentController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::active()->orderBy('name')->get();
        
        // Get selected warehouse or default to user's primary warehouse, then first active warehouse
        $defaultWarehouseId = auth('worker')->user()->primary_warehouse_id ?? $warehouses->first()?->id;
        $selectedWarehouseId = $request->get('warehouse_id', $defaultWarehouseId);
        
        $query = InternalProduct::with(['creator']);

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
            $query->leftJoin('inventories', function($join) use ($selectedWarehouseId) {
                $join->on('internal_products.id', '=', 'inventories.internal_product_id')
                     ->where('inventories.warehouse_id', '=', $selectedWarehouseId);
            })
            ->select('internal_products.*', 'inventories.quantity')
            ->orderBy('inventories.quantity', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get per_page value from request, default to 15
        $perPage = $request->get('per_page', 15);
        // Validate it's one of the allowed values
        $allowedPerPage = [10, 20, 30, 40, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 15;
        }

        $products = $query->paginate($perPage)->withQueryString();
        
        // Load inventory for selected warehouse for each product
        $products->each(function($product) use ($selectedWarehouseId) {
            $product->warehouse_inventory = Inventory::where('internal_product_id', $product->id)
                ->where('warehouse_id', $selectedWarehouseId)
                ->first();
        });

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('worker.inventory.partials.table-rows', compact('products', 'selectedWarehouseId'))->render(),
                'pagination' => (string) $products->links()
            ]);
        }

        return view('worker.inventory.index', compact('products', 'warehouses', 'selectedWarehouseId'));
    }

    public function update(Request $request, InternalProduct $product)
    {
        $validated = $request->validate([
            'quantity_to_add' => 'required|integer|min:1',
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        DB::beginTransaction();

        try {
            $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
            
            $inventory = Inventory::firstOrCreate(
                [
                    'internal_product_id' => $product->id,
                    'warehouse_id' => $validated['warehouse_id']
                ],
                ['quantity' => 0, 'updated_by' => auth('worker')->id()]
            );

            $oldQuantity = $inventory->quantity;
            $inventory->quantity += $validated['quantity_to_add'];
            $inventory->updated_by = auth('worker')->id();
            $inventory->save();

            // Log activity
            ActivityLog::log(
                auth('worker')->id(),
                'replenish',
                'inventory',
                $product->id,
                "Dopunio zalihe za: {$product->name} ({$validated['quantity_to_add']} {$product->unit}) u skladištu: {$warehouse->name}",
                [
                    'product_name' => $product->name,
                    'warehouse_name' => $warehouse->name,
                    'old_quantity' => $oldQuantity,
                    'added' => $validated['quantity_to_add'],
                    'new_quantity' => $inventory->quantity
                ]
            );

            DB::commit();

            // Preserve current page, search, sort, and warehouse filters
            $queryParams = request()->only(['page', 'search', 'sort_by', 'sort_order', 'warehouse_id', 'per_page']);
            return redirect()->route('worker.inventory.index', $queryParams)
                ->with('success', "Uspešno dodato {$validated['quantity_to_add']} {$product->unit} u zalihe proizvoda: {$product->name} (Skladište: {$warehouse->name})");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function set(Request $request, InternalProduct $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        DB::beginTransaction();

        try {
            $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
            
            $oldQuantity = Inventory::where('internal_product_id', $product->id)
                ->where('warehouse_id', $validated['warehouse_id'])
                ->value('quantity') ?? 0;
            
            $inventory = Inventory::updateOrCreate(
                [
                    'internal_product_id' => $product->id,
                    'warehouse_id' => $validated['warehouse_id']
                ],
                [
                    'quantity' => $validated['quantity'],
                    'updated_by' => auth('worker')->id()
                ]
            );

            // Log activity
            ActivityLog::log(
                auth('worker')->id(),
                'set',
                'inventory',
                $product->id,
                "Postavio količinu zaliha za: {$product->name} ({$validated['quantity']} {$product->unit}) u skladištu: {$warehouse->name}",
                [
                    'product_name' => $product->name,
                    'warehouse_name' => $warehouse->name,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $validated['quantity']
                ]
            );

            DB::commit();

            // Preserve current page, search, sort, and warehouse filters
            $queryParams = request()->only(['page', 'search', 'sort_by', 'sort_order', 'warehouse_id', 'per_page']);
            return redirect()->route('worker.inventory.index', $queryParams)
                ->with('success', "Količina postavljena na {$validated['quantity']} {$product->unit} za proizvod: {$product->name} (Skladište: {$warehouse->name})");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Greška: ' . $e->getMessage());
        }
    }
    
    public function getQuantity(InternalProduct $product, Warehouse $warehouse)
    {
        $inventory = Inventory::where('internal_product_id', $product->id)
            ->where('warehouse_id', $warehouse->id)
            ->first();

        return response()->json([
            'quantity' => $inventory ? $inventory->quantity : 0
        ]);
    }
}
