<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WarehouseInventoryExport;
use App\Imports\WarehouseInventoryImport;
use Maatwebsite\Excel\Validators\ValidationException;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('worker.warehouses.index', compact('warehouses'));
    }

    public function show(Warehouse $warehouse)
    {
        // Get all inventories for this warehouse with quantity > 0
        $inventories = Inventory::where('warehouse_id', $warehouse->id)
            ->where('quantity', '>', 0)
            ->with(['product'])
            ->orderBy('quantity', 'desc')
            ->get();

        return view('worker.warehouses.show', compact('warehouse', 'inventories'));
    }

    public function export(Warehouse $warehouse)
    {
        $filename = 'skladiste_' . str_replace(' ', '_', strtolower($warehouse->name)) . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new WarehouseInventoryExport($warehouse), $filename);
    }

    public function import(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'Molimo odaberite fajl za uvoz.',
            'file.mimes'    => 'Fajl mora biti Excel (xlsx, xls) ili CSV format.',
            'file.max'      => 'Fajl ne sme biti veći od 2MB.',
        ]);

        try {
            $import = new WarehouseInventoryImport($warehouse);
            Excel::import($import, $request->file('file'));

            $message = "Uspešno ažurirano {$import->updatedCount} artikala.";
            if ($import->skippedCount > 0) {
                $message .= " Preskočeno {$import->skippedCount} redova (nepoznat naziv materijala ili prazni podaci).";
            }

            return redirect()->route('worker.warehouses.show', $warehouse)
                ->with('success', $message);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errors = collect($failures)->map(fn($f) => "Red {$f->row()}: " . implode(', ', $f->errors()))->join(' | ');
            return redirect()->back()->with('error', 'Greška pri validaciji: ' . $errors);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Greška pri uvozu fajla: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('worker.warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Warehouse::create($validated);

        return redirect()->route('worker.warehouses.index')
            ->with('success', 'Skladište uspešno kreirano.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('worker.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $warehouse->update($validated);

        return redirect()->route('worker.warehouses.index')
            ->with('success', 'Skladište uspešno ažurirano.');
    }

    public function destroy(Warehouse $warehouse)
    {
        // Check if warehouse has inventory
        if ($warehouse->inventories()->exists()) {
            return redirect()->back()
                ->with('error', 'Ne možete obrisati skladište koje ima zalihe.');
        }

        $warehouse->delete();

        return redirect()->route('worker.warehouses.index')
            ->with('success', 'Skladište uspešno obrisano.');
    }
}
