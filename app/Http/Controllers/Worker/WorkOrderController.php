<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderSection;
use App\Models\WorkOrderItem;
use App\Models\InternalProduct;
use App\Models\Inventory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::where('worker_id', auth('worker')->id())
            ->with(['sections.items.product'])
            ->latest()
            ->paginate(15);

        return view('worker.work-orders.index', compact('workOrders'));
    }

    public function create()
    {
        $products = InternalProduct::with('inventory')->orderBy('name')->get();
        return view('worker.work-orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.hours_spent' => 'nullable|numeric|min:0',
            'sections.*.items' => 'required|array|min:1',
            'sections.*.items.*.product_id' => 'required|exists:internal_products,id',
            'sections.*.items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Check inventory availability before creating work order
            foreach ($validated['sections'] as $sectionData) {
                foreach ($sectionData['items'] as $itemData) {
                    $inventory = Inventory::where('internal_product_id', $itemData['product_id'])->first();
                    $currentStock = $inventory ? $inventory->quantity : 0;
                    
                    if ($currentStock < $itemData['quantity']) {
                        $product = InternalProduct::find($itemData['product_id']);
                        throw new \Exception("Nedovoljno zaliha za materijal '{$product->name}'. Dostupno: {$currentStock}, Potrebno: {$itemData['quantity']}");
                    }
                }
            }

            $workOrder = WorkOrder::create([
                'worker_id' => auth('worker')->id(),
                'client_name' => $validated['client_name'],
                'location' => $validated['location'],
                'status' => 'completed',
                'hourly_rate' => $validated['hourly_rate'] ?? null,
            ]);

            foreach ($validated['sections'] as $sectionData) {
                $section = $workOrder->sections()->create([
                    'title' => $sectionData['title'],
                    'hours_spent' => $sectionData['hours_spent'] ?? null,
                ]);

                foreach ($sectionData['items'] as $itemData) {
                    $product = InternalProduct::find($itemData['product_id']);
                    $section->items()->create([
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'price_at_time' => $product->price,
                    ]);

                    // Update inventory - deduct the used quantity
                    $inventory = Inventory::where('internal_product_id', $itemData['product_id'])->first();
                    if ($inventory) {
                        $inventory->quantity -= $itemData['quantity'];
                        $inventory->updated_by = auth('worker')->id();
                        $inventory->save();
                    } else {
                        // Create inventory record with negative quantity if it doesn't exist
                        Inventory::create([
                            'internal_product_id' => $itemData['product_id'],
                            'quantity' => -$itemData['quantity'],
                            'updated_by' => auth('worker')->id(),
                        ]);
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
            
            ActivityLog::log(
                auth('worker')->id(),
                'create',
                'work_order',
                $workOrder->id,
                "Kreirao radni nalog za: {$validated['client_name']}",
                [
                    'client_name' => $validated['client_name'],
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

    public function generateInvoice(Request $request, WorkOrder $workOrder)
    {
        if ($workOrder->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        if ($workOrder->has_invoice) {
            return back()->with('error', 'Faktura već postoji za ovaj radni nalog.');
        }

        $validated = $request->validate([
            'invoice_type' => 'required|in:fizicko_lice,pravno_lice',
            'invoice_company_name' => 'required|string|max:255',
            'invoice_pib' => 'nullable|string|max:20',
            'invoice_address' => 'required|string|max:255',
            'invoice_email' => 'nullable|email|max:255',
            'invoice_phone' => 'nullable|string|max:20',
        ]);

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($workOrder->id, 6, '0', STR_PAD_LEFT);

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
            'create',
            'invoice',
            $workOrder->id,
            "Generisao fakturu: {$invoiceNumber} za {$validated['invoice_company_name']}",
            [
                'invoice_number' => $invoiceNumber,
                'invoice_type' => $validated['invoice_type'],
                'company_name' => $validated['invoice_company_name'],
                'work_order_id' => $workOrder->id
            ]
        );

        return redirect()->route('worker.work-orders.invoice', $workOrder)
            ->with('success', 'Faktura uspešno kreirana.');
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
        return view('worker.work-orders.invoice', compact('workOrder'));
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
        
        $pdf = Pdf::loadView('worker.work-orders.invoice-pdf', compact('workOrder'))
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
}
