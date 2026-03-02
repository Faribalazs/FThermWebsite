<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\InternalProduct;
use App\Models\WorkOrder;
use App\Models\Ponuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $workerId = auth('worker')->id();

        // Get low stock products (limited for display)
        $lowStockProducts = InternalProduct::with('inventory')
            ->whereHas('inventory', function($query) {
                $query->whereRaw('inventories.quantity <= internal_products.low_stock_threshold');
            })
            ->orWhereDoesntHave('inventory')
            ->orderBy('name')
            ->limit(10)
            ->get();

        // Actual count without the limit
        $lowStockCount = InternalProduct::whereHas('inventory', function($query) {
                $query->whereRaw('inventories.quantity <= internal_products.low_stock_threshold');
            })
            ->orWhereDoesntHave('inventory')
            ->count();

        // Get recent work orders (exclude drafts)
        $recentWorkOrders = WorkOrder::where('worker_id', $workerId)
            ->where('status', '!=', 'draft')
            ->with(['sections.items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Draft work orders
        $draftWorkOrders = WorkOrder::where('worker_id', $workerId)
            ->where('status', 'draft')
            ->latest()
            ->get(['id', 'client_type', 'client_name', 'company_name', 'location', 'created_at', 'total_amount']);

        // Draft ponude
        $draftPonude = Ponuda::where('worker_id', $workerId)
            ->where('status', 'draft')
            ->latest()
            ->get(['id', 'client_type', 'client_name', 'company_name', 'location', 'created_at', 'total_amount']);

        // Statistics
        $totalProducts = InternalProduct::count();
        $totalWorkOrders = WorkOrder::where('worker_id', $workerId)->count();
        $pendingWorkOrders = WorkOrder::where('worker_id', $workerId)
            ->where('status', 'pending')
            ->count();
        $completedWorkOrders = WorkOrder::where('worker_id', $workerId)
            ->where('status', 'completed')
            ->count();

        // Calculate total inventory value
        $inventoryValue = InternalProduct::with('inventory')
            ->get()
            ->sum(function($product) {
                $quantity = $product->inventory->quantity ?? 0;
                return $quantity * $product->price;
            });

        // Get out of stock count
        $outOfStockCount = InternalProduct::whereDoesntHave('inventory')
            ->orWhereHas('inventory', function($query) {
                $query->where('quantity', 0);
            })
            ->count();

        return view('worker.dashboard', compact(
            'lowStockProducts',
            'lowStockCount',
            'recentWorkOrders',
            'draftWorkOrders',
            'draftPonude',
            'totalProducts',
            'totalWorkOrders',
            'pendingWorkOrders',
            'completedWorkOrders',
            'inventoryValue',
            'outOfStockCount'
        ));
    }
}
