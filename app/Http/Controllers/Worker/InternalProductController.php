<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use App\Models\ActivityLog;
use App\Exports\InternalProductsExport;
use App\Imports\InternalProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class InternalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalProduct::with('inventory');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get per_page value from request, default to 10
        $perPage = $request->get('per_page', 10);
        // Validate it's one of the allowed values
        $allowedPerPage = [10, 20, 30, 40, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $products = $query->paginate($perPage)->appends(['per_page' => $perPage]);
        
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

    /**
     * Export products to Excel
     */
    public function export()
    {
        return Excel::download(new InternalProductsExport, 'materijali_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Import products from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'Molimo odaberite fajl za uvoz.',
            'file.mimes' => 'Fajl mora biti Excel (xlsx, xls) ili CSV format.',
            'file.max' => 'Fajl ne sme biti veći od 2MB.',
        ]);

        try {
            Excel::import(new InternalProductsImport, $request->file('file'));

            // Log activity
            ActivityLog::log(
                auth('worker')->id(),
                'import',
                'product',
                null,
                'Uvezao materijale iz Excel fajla',
                ['file' => $request->file('file')->getClientOriginalName()]
            );

            return redirect()->route('worker.products.index')
                ->with('success', 'Materijali uspešno uvezeni!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Red {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('worker.products.index')
                ->with('error', 'Greške pri uvozu: ' . implode(' | ', $errorMessages));
        } catch (\Exception $e) {
            return redirect()->route('worker.products.index')
                ->with('error', 'Greška pri uvozu fajla: ' . $e->getMessage());
        }
    }
}
