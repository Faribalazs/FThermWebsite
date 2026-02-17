<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Show all activity logs, not just current user's
        $query = ActivityLog::with('user')
            ->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

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

        // Get all users who have activity logs for the filter
        $users = \App\Models\User::whereIn('id', 
            \App\Models\ActivityLog::distinct('user_id')->pluck('user_id')
        )->orderBy('name')->get();

        return view('worker.activity-logs.index', compact('logs', 'actionTypes', 'entityTypes', 'users'));
    }
}
