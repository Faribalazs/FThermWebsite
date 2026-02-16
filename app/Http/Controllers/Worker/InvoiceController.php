<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::where('worker_id', auth('worker')->id())
            ->where('has_invoice', true)
            ->with(['sections.items.product', 'worker']);

        // Search by client name or company name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'LIKE', "%{$search}%")
                  ->orWhere('invoice_company_name', 'LIKE', "%{$search}%")
                  ->orWhere('invoice_number', 'LIKE', "%{$search}%");
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by price range
        if ($request->filled('price_from')) {
            $query->where('total_amount', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('total_amount', '<=', $request->price_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $invoices = $query->paginate(15)->withQueryString();

        // Get unique locations for filter dropdown
        $locations = WorkOrder::where('worker_id', auth('worker')->id())
            ->where('has_invoice', true)
            ->distinct()
            ->pluck('location')
            ->filter();

        return view('worker.invoices.index', compact('invoices', 'locations'));
    }
}
