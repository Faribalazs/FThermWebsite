<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderSection;
use App\Models\WorkOrderItem;
use App\Models\InternalProduct;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::where('worker_id', auth('worker')->id())
            ->with(['sections.items.product']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter (has_invoice)
        if ($request->filled('status')) {
            $query->where('has_invoice', $request->status === 'invoiced');
        }

        // Price range filter
        if ($request->filled('price_from')) {
            $query->where('total_amount', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('total_amount', '<=', $request->price_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $workOrders = $query->paginate(15)->withQueryString();

        // Get unique locations for filter dropdown
        $locations = WorkOrder::where('worker_id', auth('worker')->id())
            ->distinct()
            ->pluck('location')
            ->sort()
            ->values();

        return view('worker.work-orders.index', compact('workOrders', 'locations'));
    }

    public function create()
    {
        $products = InternalProduct::with(['inventories.warehouse'])->orderBy('name')->get();
        $warehouses = Warehouse::active()->orderBy('name')->get();
        $primaryWarehouseId = auth('worker')->user()->primary_warehouse_id;
        return view('worker.work-orders.create', compact('products', 'warehouses', 'primaryWarehouseId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'client_type' => 'required|in:fizicko_lice,pravno_lice',
            'client_name' => 'required_if:client_type,fizicko_lice|nullable|string|max:255',
            'client_address' => 'nullable|string|max:255',
            'company_name' => 'required_if:client_type,pravno_lice|nullable|string|max:255',
            'pib' => 'nullable|string|max:20',
            'maticni_broj' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'location' => 'required|string|max:255',
            'km_to_destination' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.hours_spent' => 'nullable|numeric|min:0',
            'sections.*.service_price' => 'nullable|numeric|min:0',
            'sections.*.items' => 'nullable|array',
            'sections.*.items.*.product_id' => 'required_with:sections.*.items|exists:internal_products,id',
            'sections.*.items.*.quantity' => 'required_with:sections.*.items|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Check inventory availability before creating work order
            foreach ($validated['sections'] as $sectionData) {
                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        $inventory = Inventory::where('internal_product_id', $itemData['product_id'])
                            ->where('warehouse_id', $validated['warehouse_id'])
                            ->first();
                        $currentStock = $inventory ? $inventory->quantity : 0;
                        
                        if ($currentStock < $itemData['quantity']) {
                            $product = InternalProduct::find($itemData['product_id']);
                            $warehouse = Warehouse::find($validated['warehouse_id']);
                            throw new \Exception("Nedovoljno zaliha za materijal '{$product->name}' u skladištu '{$warehouse->name}'. Dostupno: {$currentStock}, Potrebno: {$itemData['quantity']}");
                        }
                    }
                }
            }

            $workOrder = WorkOrder::create([
                'worker_id' => auth('worker')->id(),
                'warehouse_id' => $validated['warehouse_id'],
                'client_type' => $validated['client_type'],
                'client_name' => $validated['client_name'] ?? null,
                'client_address' => $validated['client_address'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'pib' => $validated['pib'] ?? null,
                'maticni_broj' => $validated['maticni_broj'] ?? null,
                'company_address' => $validated['company_address'] ?? null,
                'client_phone' => $validated['client_phone'] ?? null,
                'client_email' => $validated['client_email'] ?? null,
                'location' => $validated['location'],
                'km_to_destination' => $validated['km_to_destination'] ?? null,
                'status' => 'completed',
                'hourly_rate' => $validated['hourly_rate'] ?? null,
            ]);

            foreach ($validated['sections'] as $sectionData) {
                $section = $workOrder->sections()->create([
                    'title' => $sectionData['title'],
                    'hours_spent' => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        $product = InternalProduct::find($itemData['product_id']);
                        $section->items()->create([
                            'product_id' => $itemData['product_id'],
                            'quantity' => $itemData['quantity'],
                            'price_at_time' => $product->price,
                        ]);

                        // Update inventory - deduct the used quantity
                        $inventory = Inventory::where('internal_product_id', $itemData['product_id'])
                            ->where('warehouse_id', $validated['warehouse_id'])
                            ->first();
                        if ($inventory) {
                            $inventory->quantity -= $itemData['quantity'];
                            $inventory->updated_by = auth('worker')->id();
                            $inventory->save();
                        } else {
                            // Create inventory record with negative quantity if it doesn't exist
                            Inventory::create([
                                'internal_product_id' => $itemData['product_id'],
                                'warehouse_id' => $validated['warehouse_id'],
                                'quantity' => -$itemData['quantity'],
                                'updated_by' => auth('worker')->id(),
                            ]);
                        }
                    }
                }
            }

            $total = $workOrder->calculateTotal();
            $workOrder->update(['total_amount' => $total]);

            // Log activity
            $itemCount = 0;
            foreach ($validated['sections'] as $section) {
                $itemCount += count($section['items']);
            }
            
            $clientDisplay = $validated['client_type'] === 'pravno_lice' 
                ? $validated['company_name'] 
                : $validated['client_name'];
            
            ActivityLog::log(
                auth('worker')->id(),
                'create',
                'work_order',
                $workOrder->id,
                "Kreirao radni nalog za: {$clientDisplay}",
                [
                    'client_type' => $validated['client_type'],
                    'client_display' => $clientDisplay,
                    'location' => $validated['location'],
                    'sections_count' => count($validated['sections']),
                    'items_count' => $itemCount,
                    'total_amount' => $total
                ]
            );

            DB::commit();

            return redirect()->route('worker.work-orders.show', $workOrder)
                ->with('success', 'Radni nalog uspešno kreiran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function show(WorkOrder $workOrder)
    {
        // Ensure worker can only view their own work orders
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $workOrder->load(['sections.items.product']);
        return view('worker.work-orders.show', compact('workOrder'));
    }

    public function edit(WorkOrder $workOrder)
    {
        // Ensure worker can only edit their own work orders
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        // Load relationships
        $workOrder->load(['sections.items.product', 'warehouse']);
        
        // Calculate quantities currently used in this work order
        $usedQuantities = [];
        foreach ($workOrder->sections as $section) {
            foreach ($section->items as $item) {
                $usedQuantities[$item->product_id] = ($usedQuantities[$item->product_id] ?? 0) + $item->quantity;
            }
        }
        
        // Get all internal products with all warehouse inventories
        $products = InternalProduct::with(['inventories.warehouse'])->orderBy('name')->get();
        
        // Adjust inventory quantities to include what's used in this work order
        // This shows the "available" stock as if this work order didn't exist yet
        foreach ($products as $product) {
            if (isset($usedQuantities[$product->id]) && $product->inventories) {
                // Add back the used quantity to the warehouse this work order is using
                foreach ($product->inventories as $inventory) {
                    if ($inventory->warehouse_id == $workOrder->warehouse_id) {
                        $inventory->quantity += $usedQuantities[$product->id];
                    }
                }
            }
        }
        
        // Get warehouses
        $warehouses = Warehouse::active()->orderBy('name')->get();
        $primaryWarehouseId = auth('worker')->user()->primary_warehouse_id;
        
        return view('worker.work-orders.edit', compact('workOrder', 'products', 'warehouses', 'primaryWarehouseId'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        // Ensure worker can only update their own work orders
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'client_type' => 'required|in:fizicko_lice,pravno_lice',
            'client_name' => 'required_if:client_type,fizicko_lice|nullable|string|max:255',
            'client_address' => 'nullable|string|max:255',
            'company_name' => 'required_if:client_type,pravno_lice|nullable|string|max:255',
            'pib' => 'nullable|string|max:20',
            'maticni_broj' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'location' => 'required|string|max:255',
            'km_to_destination' => 'nullable|numeric|min:0',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.hours_spent' => 'nullable|numeric|min:0',
            'sections.*.service_price' => 'nullable|numeric|min:0',
            'sections.*.items' => 'nullable|array',
            'sections.*.items.*.product_id' => 'required_with:sections.*.items|exists:internal_products,id',
            'sections.*.items.*.quantity' => 'required_with:sections.*.items|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Calculate inventory changes needed
            $oldItems = [];
            foreach ($workOrder->sections as $section) {
                foreach ($section->items as $item) {
                    $oldItems[$item->product_id] = ($oldItems[$item->product_id] ?? 0) + $item->quantity;
                }
            }

            $newItems = [];
            foreach ($validated['sections'] as $sectionData) {
                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        $newItems[$itemData['product_id']] = ($newItems[$itemData['product_id']] ?? 0) + $itemData['quantity'];
                    }
                }
            }

            // Check inventory availability for increased quantities
            foreach ($newItems as $productId => $newQty) {
                $oldQty = $oldItems[$productId] ?? 0;
                $difference = $newQty - $oldQty;
                
                if ($difference > 0) {
                    $inventory = Inventory::where('internal_product_id', $productId)
                        ->where('warehouse_id', $validated['warehouse_id'])
                        ->first();
                    $currentStock = $inventory ? $inventory->quantity : 0;
                    
                    if ($currentStock < $difference) {
                        $product = InternalProduct::find($productId);
                        $warehouse = Warehouse::find($validated['warehouse_id']);
                        throw new \Exception("Nedovoljno zaliha za materijal '{$product->name}' u skladištu '{$warehouse->name}'. Dostupno: {$currentStock}, Potrebno dodatno: {$difference}");
                    }
                }
            }

            // Return old items to inventory (original warehouse)
            foreach ($oldItems as $productId => $quantity) {
                $inventory = Inventory::where('internal_product_id', $productId)
                    ->where('warehouse_id', $workOrder->warehouse_id)
                    ->first();
                if ($inventory) {
                    $inventory->quantity += $quantity;
                    $inventory->updated_by = auth('worker')->id();
                    $inventory->save();
                }
            }

            // Update work order basic info
            $workOrder->update([
                'warehouse_id' => $validated['warehouse_id'],
                'client_type' => $validated['client_type'],
                'client_name' => $validated['client_name'] ?? null,
                'client_address' => $validated['client_address'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'pib' => $validated['pib'] ?? null,
                'maticni_broj' => $validated['maticni_broj'] ?? null,
                'company_address' => $validated['company_address'] ?? null,
                'client_phone' => $validated['client_phone'] ?? null,
                'client_email' => $validated['client_email'] ?? null,
                'location' => $validated['location'],
                'km_to_destination' => $validated['km_to_destination'] ?? null,
            ]);

            // Delete old sections and items
            $workOrder->sections()->delete();

            // Create new sections and items
            foreach ($validated['sections'] as $sectionData) {
                $section = $workOrder->sections()->create([
                    'title' => $sectionData['title'],
                    'hours_spent' => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        $product = InternalProduct::find($itemData['product_id']);
                        $section->items()->create([
                            'product_id' => $itemData['product_id'],
                            'quantity' => $itemData['quantity'],
                            'price_at_time' => $product->price,
                        ]);

                        // Deduct from inventory
                        $inventory = Inventory::where('internal_product_id', $itemData['product_id'])
                            ->where('warehouse_id', $validated['warehouse_id'])
                            ->first();
                        if ($inventory) {
                            $inventory->quantity -= $itemData['quantity'];
                            $inventory->updated_by = auth('worker')->id();
                            $inventory->save();
                        } else {
                            Inventory::create([
                                'internal_product_id' => $itemData['product_id'],
                                'warehouse_id' => $validated['warehouse_id'],
                                'quantity' => -$itemData['quantity'],
                                'updated_by' => auth('worker')->id(),
                            ]);
                        }
                    }
                }
            }

            // Update total amount
            $total = $workOrder->calculateTotal();
            $workOrder->update(['total_amount' => $total]);

            // Log activity
            $clientDisplay = $validated['client_type'] === 'pravno_lice' 
                ? $validated['company_name'] 
                : $validated['client_name'];
            
            ActivityLog::log(
                auth('worker')->id(),
                'update_work_order',
                'work_order',
                $workOrder->id,
                "Ažuriran radni nalog za {$clientDisplay}"
            );

            DB::commit();
            return redirect()->route('worker.work-orders.show', $workOrder)->with('success', 'Radni nalog uspešno ažuriran!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function generateInvoice(Request $request, WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $isRegenerating = $workOrder->has_invoice;

        $validated = $request->validate([
            'invoice_type' => 'required|in:fizicko_lice,pravno_lice',
            'invoice_company_name' => 'required|string|max:255',
            'invoice_pib' => 'nullable|string|max:20',
            'invoice_address' => 'required|string|max:255',
            'invoice_email' => 'nullable|email|max:255',
            'invoice_phone' => 'nullable|string|max:20',
        ]);

        // Generate invoice number (format: YY-ID, e.g., 26-7 for 2026)
        // Keep existing invoice number if regenerating, otherwise create new one
        $invoiceNumber = $workOrder->invoice_number ?? (substr(date('Y'), -2) . '-' . $workOrder->id);

        $workOrder->update([
            'invoice_type' => $validated['invoice_type'],
            'invoice_number' => $invoiceNumber,
            'invoice_company_name' => $validated['invoice_company_name'],
            'invoice_pib' => $validated['invoice_pib'] ?? null,
            'invoice_address' => $validated['invoice_address'],
            'invoice_email' => $validated['invoice_email'] ?? null,
            'invoice_phone' => $validated['invoice_phone'] ?? null,
            'has_invoice' => true,
        ]);

        // Log activity
        ActivityLog::log(
            auth('worker')->id(),
            $isRegenerating ? 'update' : 'create',
            'invoice',
            $workOrder->id,
            $isRegenerating 
                ? "Regenerisao fakturu: {$invoiceNumber} za {$validated['invoice_company_name']}"
                : "Generisao fakturu: {$invoiceNumber} za {$validated['invoice_company_name']}",
            [
                'invoice_number' => $invoiceNumber,
                'invoice_type' => $validated['invoice_type'],
                'company_name' => $validated['invoice_company_name'],
                'work_order_id' => $workOrder->id,
                'is_regenerating' => $isRegenerating
            ]
        );

        return redirect()->route('worker.work-orders.invoice', $workOrder)
            ->with('success', $isRegenerating ? 'Faktura uspešno regenerisana.' : 'Faktura uspešno kreirana.');
    }

    public function showInvoice(WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        if (!$workOrder->has_invoice) {
            return redirect()->route('worker.work-orders.show', $workOrder)
                ->with('error', 'Faktura nije kreirana.');
        }

        $workOrder->load(['sections.items.product', 'worker']);
        
        // Get all settings for the invoice view
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;
        $companyName = Setting::where('key', 'company_name')->value('value') ?? 'F-Therm d.o.o.';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companySifraDelatnosti = Setting::where('key', 'company_sifra_delatnosti')->value('value') ?? '';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';
        
        return view('worker.work-orders.invoice', compact(
            'workOrder', 
            'kmPrice',
            'companyName',
            'companyPib',
            'companyMaticniBroj',
            'companySifraDelatnosti',
            'companyPhone',
            'companyEmail',
            'companyAddress',
            'companyBankAccount'
        ));
    }

    public function downloadInvoice(WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        if (!$workOrder->has_invoice) {
            abort(404);
        }

        $workOrder->load(['sections.items.product', 'worker']);
        
        // Get all settings for the invoice
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;
        $companyName = Setting::where('key', 'company_name')->value('value') ?? 'F-Therm d.o.o.';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companySifraDelatnosti = Setting::where('key', 'company_sifra_delatnosti')->value('value') ?? '';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';
        
        $pdf = Pdf::loadView('worker.work-orders.invoice-pdf', compact(
            'workOrder', 
            'kmPrice',
            'companyName',
            'companyPib',
            'companyMaticniBroj',
            'companySifraDelatnosti',
            'companyPhone',
            'companyEmail',
            'companyAddress',
            'companyBankAccount'
        ))
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans');
        
        return $pdf->download('Faktura-' . $workOrder->invoice_number . '.pdf');
    }

    public function destroy(WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $workOrder->delete();

        return redirect()->route('worker.work-orders.index')
            ->with('success', 'Radni nalog obrisan.');
    }

    public function exportPdf(WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $workOrder->load(['sections.items.product', 'worker']);
        
        $pdf = Pdf::loadView('worker.work-orders.pdf', compact('workOrder'))
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setPaper('a4');
        
        $clientName = $workOrder->client_type === 'pravno_lice' 
            ? $workOrder->company_name 
            : $workOrder->client_name;
        $fileName = 'RadniNalog-' . str_replace(' ', '-', $clientName) . '-' . $workOrder->id . '.pdf';
        
        return $pdf->download($fileName);
    }
}
