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
use App\Models\Contact;
use App\Models\Setting;
use App\Services\EfakturaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::where('worker_id', auth('worker')->id())
            ->withCount('sections');

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

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'draft') {
                $query->where('status', 'draft');
            } else {
                $query->where('status', '!=', 'draft')
                      ->where('has_invoice', $request->status === 'invoiced');
            }
        }

        // Price range filter
        if ($request->filled('price_from')) {
            $query->where('total_amount', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('total_amount', '<=', $request->price_to);
        }

        // Sorting (whitelist to prevent column injection)
        $allowedSort = ['created_at', 'total_amount', 'location', 'status'];
        $sortBy = in_array($request->get('sort_by'), $allowedSort) ? $request->get('sort_by') : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';
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
        $products = InternalProduct::with(['inventories:id,internal_product_id,warehouse_id,quantity'])
            ->select('id', 'name', 'unit', 'price')
            ->orderBy('name')
            ->get();
        $warehouses = Warehouse::active()->orderBy('name')->get();
        $primaryWarehouseId = auth('worker')->user()->primary_warehouse_id;
        $contacts = \App\Models\Contact::where('created_by', auth('worker')->id())->orderBy('type')->orderBy('client_name')->orderBy('company_name')->get();
        return view('worker.work-orders.create', compact('products', 'warehouses', 'primaryWarehouseId', 'contacts'));
    }

    public function autosave(Request $request)
    {
        $draftId = $request->input('draft_id');
        $workOrder = null;

        if ($draftId) {
            $workOrder = WorkOrder::where('id', $draftId)
                ->where('worker_id', auth('worker')->id())
                ->where('status', 'draft')
                ->first();
        }

        $attrs = [
            'worker_id'         => auth('worker')->id(),
            'warehouse_id'      => $request->input('warehouse_id') ?: null,
            'client_type'       => $request->input('client_type') ?: 'fizicko_lice',
            'client_name'       => $request->input('client_name') ?: null,
            'client_address'    => $request->input('client_address') ?: null,
            'company_name'      => $request->input('company_name') ?: null,
            'pib'               => $request->input('pib') ?: null,
            'maticni_broj'      => $request->input('maticni_broj') ?: null,
            'company_address'   => $request->input('company_address') ?: null,
            'client_phone'      => $request->input('client_phone') ?: null,
            'client_email'      => $request->input('client_email') ?: null,
            'location'          => $request->input('location') ?: null,
            'km_to_destination' => $request->input('km_to_destination') ?: null,
            'hourly_rate'       => $request->input('hourly_rate') ?: null,
            'status'            => 'draft',
        ];

        if ($workOrder) {
            $workOrder->update($attrs);
        } else {
            $workOrder = WorkOrder::create($attrs);
        }

        // Batch-load all needed products (eliminates N+1 per item)
        $allProductIds = collect($request->input('sections', []))
            ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
            ->unique()->values()->all();
        $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->select('id', 'price')->get()->keyBy('id') : collect();

        // Wipe and rebuild sections / items inside a transaction
        // (cascade FK on work_order_items ensures items are deleted when sections are deleted)
        DB::transaction(function () use ($workOrder, $request, $productMap) {
            $workOrder->sections()->delete();

            foreach ($request->input('sections', []) as $sectionData) {
                // In autosave/draft context, keep sections even without a title
                // so that items (materials) are not lost while the user is still typing.
                $sectionTitle = trim($sectionData['title'] ?? '');
                if ($sectionTitle === '') {
                    $sectionTitle = 'Usluga'; // temporary placeholder
                }
                $section = $workOrder->sections()->create([
                    'title'         => $sectionTitle,
                    'hours_spent'   => $sectionData['hours_spent'] ?: null,
                    'service_price' => $sectionData['service_price'] ?: null,
                ]);
                foreach ($sectionData['items'] ?? [] as $itemData) {
                    if (empty($itemData['product_id'])) continue;
                    $product = $productMap->get($itemData['product_id']);
                    if (!$product) continue;
                    $section->items()->create([
                        'product_id'    => $itemData['product_id'],
                        'quantity'      => max(1, (int) ($itemData['quantity'] ?? 1)),
                        'price_at_time' => $product->price,
                    ]);
                }
            }
        });

        $workOrder->load('sections.items');
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        $workOrder->update(['total_amount' => $workOrder->calculateGrandTotal($kmPrice)]);

        return response()->json([
            'id'       => $workOrder->id,
            'saved_at' => now()->format('H:i:s'),
            'edit_url' => route('worker.work-orders.edit', $workOrder),
        ]);
    }

    public function autosaveEdit(Request $request, WorkOrder $workOrder)
    {
        // Ensure the worker owns this work order
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update header fields without touching status or performing inventory deduction
        $workOrder->update([
            'warehouse_id'      => $request->input('warehouse_id') ?: $workOrder->warehouse_id,
            'client_type'       => $request->input('client_type') ?: $workOrder->client_type,
            'client_name'       => $request->input('client_name') ?: null,
            'client_address'    => $request->input('client_address') ?: null,
            'company_name'      => $request->input('company_name') ?: null,
            'pib'               => $request->input('pib') ?: null,
            'maticni_broj'      => $request->input('maticni_broj') ?: null,
            'company_address'   => $request->input('company_address') ?: null,
            'client_phone'      => $request->input('client_phone') ?: null,
            'client_email'      => $request->input('client_email') ?: null,
            'location'          => $request->input('location') ?: null,
            'km_to_destination' => $request->input('km_to_destination') ?: null,
            'hourly_rate'       => $request->input('hourly_rate') ?: null,
        ]);

        // Batch-load all needed products (eliminates N+1 per item)
        $allProductIds = collect($request->input('sections', []))
            ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
            ->unique()->values()->all();
        $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->select('id', 'price')->get()->keyBy('id') : collect();

        // Wipe and rebuild sections / items inside a transaction
        // (cascade FK on work_order_items ensures items are deleted when sections are deleted)
        DB::transaction(function () use ($workOrder, $request, $productMap) {
            $workOrder->sections()->delete();

            foreach ($request->input('sections', []) as $sectionData) {
                // In autosave context, keep sections even without a title
                $sectionTitle = trim($sectionData['title'] ?? '');
                if ($sectionTitle === '') {
                    $sectionTitle = 'Usluga'; // temporary placeholder
                }
                $section = $workOrder->sections()->create([
                    'title'         => $sectionTitle,
                    'hours_spent'   => $sectionData['hours_spent'] ?: null,
                    'service_price' => $sectionData['service_price'] ?: null,
                ]);
                foreach ($sectionData['items'] ?? [] as $itemData) {
                    if (empty($itemData['product_id'])) continue;
                    $product = $productMap->get($itemData['product_id']);
                    if (!$product) continue;
                    $section->items()->create([
                        'product_id'    => $itemData['product_id'],
                        'quantity'      => max(1, (int) ($itemData['quantity'] ?? 1)),
                        'price_at_time' => $product->price,
                    ]);
                }
            }
        });

        $workOrder->load('sections.items');
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        $workOrder->update(['total_amount' => $workOrder->calculateGrandTotal($kmPrice)]);

        return response()->json(['saved_at' => now()->format('H:i:s')]);
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
            'sections.*.items.*.product_id' => 'nullable|exists:internal_products,id',
            'sections.*.items.*.quantity' => 'nullable|integer|min:1',
        ], [
            'warehouse_id.required' => 'Skladište je obavezno.',
            'client_type.required' => 'Tip klijenta je obavezan.',
            'client_name.required_if' => 'Ime i prezime klijenta je obavezno.',
            'company_name.required_if' => 'Naziv firme je obavezan.',
            'client_email.email' => 'Email adresa nije ispravna.',
            'location.required' => 'Lokacija radova je obavezna.',
            'km_to_destination.numeric' => 'Kilometraža mora biti broj.',
            'hourly_rate.numeric' => 'Cena po satu mora biti broj.',
            'sections.required' => 'Dodajte barem jednu uslugu.',
            'sections.min' => 'Dodajte barem jednu uslugu.',
            'sections.*.title.required' => 'Naziv usluge je obavezan.',
            'sections.*.hours_spent.numeric' => 'Sati moraju biti broj.',
            'sections.*.service_price.numeric' => 'Cena usluge mora biti broj.',
            'sections.*.items.*.product_id.exists' => 'Izabrani materijal ne postoji.',
            'sections.*.items.*.quantity.required_with' => 'Količina je obavezna kada je materijal izabran.',
            'sections.*.items.*.quantity.integer' => 'Količina mora biti ceo broj.',
            'sections.*.items.*.quantity.min' => 'Količina mora biti najmanje 1.',
        ]);

        DB::beginTransaction();

        try {
            // Batch-load all products and inventories to avoid N+1 queries
            $allProductIds = collect($validated['sections'])
                ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
                ->unique()->values()->all();
            $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->get()->keyBy('id') : collect();
            $inventoryMap = $allProductIds ? Inventory::whereIn('internal_product_id', $allProductIds)
                ->where('warehouse_id', $validated['warehouse_id'])
                ->get()->keyBy('internal_product_id') : collect();
            $warehouse = Warehouse::find($validated['warehouse_id']);

            // Check inventory availability before creating work order
            foreach ($validated['sections'] as $sectionData) {
                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $inventory = $inventoryMap->get($itemData['product_id']);
                        $currentStock = $inventory ? $inventory->quantity : 0;
                        $neededQty = max(1, (int) ($itemData['quantity'] ?? 1));
                        if ($currentStock < $neededQty) {
                            $product = $productMap->get($itemData['product_id']);
                            throw new \Exception("Nedovoljno zaliha za materijal '{$product->name}' u skladištu '{$warehouse->name}'. Dostupno: {$currentStock}, Potrebno: {$neededQty}");
                        }
                    }
                }
            }

            // Reuse existing draft if one was being autosaved
            $draftId = $request->input('draft_id');
            $workOrder = null;
            if ($draftId) {
                $workOrder = WorkOrder::where('id', $draftId)
                    ->where('worker_id', auth('worker')->id())
                    ->where('status', 'draft')
                    ->first();
                if ($workOrder) {
                    $workOrder->load('sections.items');
                    foreach ($workOrder->sections as $section) {
                        $section->items()->delete();
                    }
                    $workOrder->sections()->delete();
                    $workOrder->update([
                        'warehouse_id'      => $validated['warehouse_id'],
                        'client_type'       => $validated['client_type'],
                        'client_name'       => $validated['client_name'] ?? null,
                        'client_address'    => $validated['client_address'] ?? null,
                        'company_name'      => $validated['company_name'] ?? null,
                        'pib'               => $validated['pib'] ?? null,
                        'maticni_broj'      => $validated['maticni_broj'] ?? null,
                        'company_address'   => $validated['company_address'] ?? null,
                        'client_phone'      => $validated['client_phone'] ?? null,
                        'client_email'      => $validated['client_email'] ?? null,
                        'location'          => $validated['location'],
                        'km_to_destination' => $validated['km_to_destination'] ?? null,
                        'status'            => 'completed',
                        'hourly_rate'       => $validated['hourly_rate'] ?? null,
                    ]);
                }
            }
            if (!$workOrder) {
                $workOrder = WorkOrder::create([
                    'worker_id'         => auth('worker')->id(),
                    'warehouse_id'      => $validated['warehouse_id'],
                    'client_type'       => $validated['client_type'],
                    'client_name'       => $validated['client_name'] ?? null,
                    'client_address'    => $validated['client_address'] ?? null,
                    'company_name'      => $validated['company_name'] ?? null,
                    'pib'               => $validated['pib'] ?? null,
                    'maticni_broj'      => $validated['maticni_broj'] ?? null,
                    'company_address'   => $validated['company_address'] ?? null,
                    'client_phone'      => $validated['client_phone'] ?? null,
                    'client_email'      => $validated['client_email'] ?? null,
                    'location'          => $validated['location'],
                    'km_to_destination' => $validated['km_to_destination'] ?? null,
                    'status'            => 'completed',
                    'hourly_rate'       => $validated['hourly_rate'] ?? null,
                ]);
            }

            foreach ($validated['sections'] as $sectionData) {
                $section = $workOrder->sections()->create([
                    'title' => $sectionData['title'],
                    'hours_spent' => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $product = $productMap->get($itemData['product_id']);
                        if (!$product) continue;
                        $qty = max(1, (int) ($itemData['quantity'] ?? 1));
                        $section->items()->create([
                            'product_id' => $itemData['product_id'],
                            'quantity' => $qty,
                            'price_at_time' => $product->price,
                        ]);

                        // Update inventory - deduct the used quantity
                        $inventory = $inventoryMap->get($itemData['product_id']);
                        if ($inventory) {
                            $inventory->quantity -= $qty;
                            $inventory->updated_by = auth('worker')->id();
                            $inventory->save();
                        } else {
                            // Create inventory record with negative quantity if it doesn't exist
                            Inventory::create([
                                'internal_product_id' => $itemData['product_id'],
                                'warehouse_id' => $validated['warehouse_id'],
                                'quantity' => -$qty,
                                'updated_by' => auth('worker')->id(),
                            ]);
                        }
                    }
                }
            }

            $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
            $total = $workOrder->calculateGrandTotal($kmPrice);
            $workOrder->update(['total_amount' => $total]);

            // Log activity
            $itemCount = 0;
            foreach ($validated['sections'] as $section) {
                $itemCount += count($section['items'] ?? []);
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

            // Save client data as contact if checkbox was checked
            if ($request->has('save_as_contact')) {
                $contactData = [
                    'created_by' => auth('worker')->id(),
                    'type' => $validated['client_type'],
                    'client_name' => $validated['client_name'] ?? null,
                    'client_address' => $validated['client_address'] ?? null,
                    'client_phone' => $validated['client_phone'] ?? null,
                    'client_email' => $validated['client_email'] ?? null,
                ];

                if ($validated['client_type'] === 'pravno_lice') {
                    $contactData['company_name'] = $validated['company_name'] ?? null;
                    $contactData['pib'] = $validated['pib'] ?? null;
                    $contactData['maticni_broj'] = $validated['maticni_broj'] ?? null;
                    $contactData['company_address'] = $validated['company_address'] ?? null;
                }

                Contact::create($contactData);
            }

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
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        $workOrder->load(['sections.items.product']);
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;
        return view('worker.work-orders.show', compact('workOrder', 'kmPrice'));
    }

    public function edit(WorkOrder $workOrder)
    {
        // Ensure worker can only edit their own work orders
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
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
        $products = InternalProduct::with(['inventories:id,internal_product_id,warehouse_id,quantity'])
            ->select('id', 'name', 'unit', 'price')
            ->orderBy('name')->get();
        
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
        
        $contacts = \App\Models\Contact::where('created_by', auth('worker')->id())->orderBy('type')->orderBy('client_name')->orderBy('company_name')->get();
        return view('worker.work-orders.edit', compact('workOrder', 'products', 'warehouses', 'primaryWarehouseId', 'contacts'));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        // Ensure worker can only update their own work orders
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
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
            'hourly_rate' => 'nullable|numeric|min:0',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.hours_spent' => 'nullable|numeric|min:0',
            'sections.*.service_price' => 'nullable|numeric|min:0',
            'sections.*.items' => 'nullable|array',
            'sections.*.items.*.product_id' => 'nullable|exists:internal_products,id',
            'sections.*.items.*.quantity' => 'required_with:sections.*.items.*.product_id|integer|min:1',
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
                        if (empty($itemData['product_id'])) continue;
                        $newItems[$itemData['product_id']] = ($newItems[$itemData['product_id']] ?? 0) + max(1, (int) ($itemData['quantity'] ?? 1));
                    }
                }
            }

            // Batch-load products and inventories to avoid N+1 queries
            $allOldProductIds = array_keys($oldItems);
            $allNewProductIds = array_keys($newItems);
            $allProductIds = array_unique(array_merge($allOldProductIds, $allNewProductIds));
            $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->get()->keyBy('id') : collect();
            // Inventories for the new/target warehouse
            $inventoryNewMap = $allNewProductIds ? Inventory::whereIn('internal_product_id', $allNewProductIds)
                ->where('warehouse_id', $validated['warehouse_id'])
                ->get()->keyBy('internal_product_id') : collect();
            // Inventories for the old warehouse (may differ when changing warehouse)
            $inventoryOldMap = ($workOrder->warehouse_id == (int)$validated['warehouse_id'])
                ? $inventoryNewMap
                : ($allOldProductIds ? Inventory::whereIn('internal_product_id', $allOldProductIds)
                    ->where('warehouse_id', $workOrder->warehouse_id)
                    ->get()->keyBy('internal_product_id') : collect());
            $warehouse = Warehouse::find($validated['warehouse_id']);

            // Check inventory availability for increased quantities
            foreach ($newItems as $productId => $newQty) {
                $oldQty = $oldItems[$productId] ?? 0;
                $difference = $newQty - $oldQty;

                if ($difference > 0) {
                    $inventory = $inventoryNewMap->get($productId);
                    $currentStock = $inventory ? $inventory->quantity : 0;

                    if ($currentStock < $difference) {
                        $product = $productMap->get($productId);
                        throw new \Exception("Nedovoljno zaliha za materijal '{$product->name}' u skladištu '{$warehouse->name}'. Dostupno: {$currentStock}, Potrebno dodatno: {$difference}");
                    }
                }
            }

            // Return old items to inventory (original warehouse)
            foreach ($oldItems as $productId => $quantity) {
                $inventory = $inventoryOldMap->get($productId);
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
                'hourly_rate' => $validated['hourly_rate'] ?? null,
                'status' => 'completed',
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
                        if (empty($itemData['product_id'])) continue;
                        $product = $productMap->get($itemData['product_id']);
                        if (!$product) continue;
                        $qty = max(1, (int) ($itemData['quantity'] ?? 1));
                        $section->items()->create([
                            'product_id' => $itemData['product_id'],
                            'quantity' => $qty,
                            'price_at_time' => $product->price,
                        ]);

                        // Deduct from inventory
                        $inventory = $inventoryNewMap->get($itemData['product_id']);
                        if ($inventory) {
                            $inventory->quantity -= $qty;
                            $inventory->updated_by = auth('worker')->id();
                            $inventory->save();
                        } else {
                            Inventory::create([
                                'internal_product_id' => $itemData['product_id'],
                                'warehouse_id' => $validated['warehouse_id'],
                                'quantity' => -$qty,
                                'updated_by' => auth('worker')->id(),
                            ]);
                        }
                    }
                }
            }

            // Update total amount
            $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
            $total = $workOrder->calculateGrandTotal($kmPrice);
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
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
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

        // Generate invoice number (format: YY-N, e.g., 26-7 for 2026)
        // Keep existing invoice number if regenerating, otherwise create new one using auto-increment counter
        if ($workOrder->invoice_number) {
            $invoiceNumber = $workOrder->invoice_number;
        } else {
            $yearPrefix = substr(date('Y'), -2);
            $counterStart = (int) (Setting::where('key', 'invoice_counter_start')->value('value') ?? 1);
            
            // Find the highest existing invoice number for this year
            $maxNumber = \App\Models\WorkOrder::where('invoice_number', 'LIKE', $yearPrefix . '-%')
                ->get()
                ->map(function ($wo) use ($yearPrefix) {
                    $parts = explode('-', $wo->invoice_number);
                    return isset($parts[1]) ? (int) $parts[1] : 0;
                })
                ->max();
            
            $nextNumber = max($counterStart, ($maxNumber ?? 0) + 1);
            $invoiceNumber = $yearPrefix . '-' . $nextNumber;
        }

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
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        if (!$workOrder->has_invoice) {
            return redirect()->route('worker.work-orders.show', $workOrder)
                ->with('error', 'Faktura nije kreirana.');
        }

        $workOrder->load(['sections.items.product', 'worker']);

        // Single query for all company settings
        $settings = Setting::whereIn('key', [
            'km_price', 'company_name', 'company_pib', 'company_maticni_broj',
            'company_sifra_delatnosti', 'company_phone', 'company_email', 'company_address', 'company_bank_account',
        ])->pluck('value', 'key');
        $kmPrice             = $settings->get('km_price', 0);
        $companyName         = $settings->get('company_name', 'F-Therm d.o.o.');
        $companyPib          = $settings->get('company_pib', '');
        $companyMaticniBroj  = $settings->get('company_maticni_broj', '');
        $companySifraDelatnosti = $settings->get('company_sifra_delatnosti', '');
        $companyPhone        = $settings->get('company_phone', '');
        $companyEmail        = $settings->get('company_email', '');
        $companyAddress      = $settings->get('company_address', '');
        $companyBankAccount  = $settings->get('company_bank_account', '');

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
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        if (!$workOrder->has_invoice) {
            abort(404);
        }

        $workOrder->load(['sections.items.product', 'worker']);

        // Single query for all company settings
        $settings = Setting::whereIn('key', [
            'km_price', 'company_name', 'company_pib', 'company_maticni_broj',
            'company_sifra_delatnosti', 'company_phone', 'company_email', 'company_address', 'company_bank_account',
        ])->pluck('value', 'key');
        $kmPrice             = $settings->get('km_price', 0);
        $companyName         = $settings->get('company_name', 'F-Therm d.o.o.');
        $companyPib          = $settings->get('company_pib', '');
        $companyMaticniBroj  = $settings->get('company_maticni_broj', '');
        $companySifraDelatnosti = $settings->get('company_sifra_delatnosti', '');
        $companyPhone        = $settings->get('company_phone', '');
        $companyEmail        = $settings->get('company_email', '');
        $companyAddress      = $settings->get('company_address', '');
        $companyBankAccount  = $settings->get('company_bank_account', '');

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

    public function sendToEfaktura(WorkOrder $workOrder)
    {
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        if (!$workOrder->has_invoice) {
            return back()->with('error', 'Faktura nije generisana za ovaj radni nalog.');
        }

        try {
            $service = new EfakturaService();
            $result = $service->sendInvoice($workOrder);

            if ($result['success']) {
                ActivityLog::log(
                    auth('worker')->id(),
                    'efaktura_sent',
                    'invoice',
                    $workOrder->id,
                    "Faktura {$workOrder->invoice_number} poslata na eFaktura sistem"
                );

                return back()->with('success', 'Faktura uspešno poslata na eFaktura sistem.');
            }

            return back()->with('error', 'Greška pri slanju na eFaktura: ' . ($result['data']['Message'] ?? $result['data']['message'] ?? 'Server je vratio status ' . $result['status']));
        } catch (\Exception $e) {
            return back()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function destroy(WorkOrder $workOrder)
    {
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        $workOrder->delete();

        return redirect()->route('worker.work-orders.index')
            ->with('success', 'Radni nalog obrisan.');
    }

    public function exportPdf(WorkOrder $workOrder)
    {
        if ((int)$workOrder->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        $workOrder->load(['sections.items.product', 'worker']);
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;

        $pdf = Pdf::loadView('worker.work-orders.pdf', compact('workOrder', 'kmPrice'))
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
