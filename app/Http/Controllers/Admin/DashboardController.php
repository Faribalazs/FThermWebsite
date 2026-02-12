<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_services' => Service::count(),
            'total_inquiries' => Inquiry::count(),
            'unread_inquiries' => Inquiry::where('is_read', false)->count(),
        ];

        $recent_inquiries = Inquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_inquiries'));
    }
}
