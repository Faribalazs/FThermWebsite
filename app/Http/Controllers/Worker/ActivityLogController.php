<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::where('user_id', auth('worker')->id())
            ->with('user')
            ->latest();

        // Filter by action type
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        // Filter by entity type
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();

        $actionTypes = [
            'create' => 'Kreiranje',
            'update' => 'Ažuriranje',
            'delete' => 'Brisanje',
            'replenish' => 'Dopuna',
            'set' => 'Postavljanje',
        ];

        $entityTypes = [
            'product' => 'Materijal',
            'work_order' => 'Radni Nalog',
            'invoice' => 'Faktura',
            'inventory' => 'Zalihe',
        ];

        return view('worker.activity-logs.index', compact('logs', 'actionTypes', 'entityTypes'));
    }
}
