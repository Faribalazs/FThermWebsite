<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Inquiry;
use App\Models\PageView;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        $analytics = $this->analytics();

        return view('admin.dashboard', compact('stats', 'recent_inquiries', 'analytics'));
    }

    private function analytics(): array
    {
        $empty = [
            'available' => false, 'today' => 0, 'seven_days' => 0, 'thirty_days' => 0,
            'unique_thirty_days' => 0, 'growth' => 0, 'conversion' => 0,
            'trend' => collect(), 'popular_pages' => collect(), 'devices' => collect(),
            'languages' => collect(), 'sources' => collect(),
        ];

        if (! Schema::hasTable('page_views')) {
            return $empty;
        }

        $now = now();
        $thirtyDaysAgo = $now->copy()->subDays(29)->startOfDay();
        $previousStart = $thirtyDaysAgo->copy()->subDays(30);
        $previousEnd = $thirtyDaysAgo->copy()->subSecond();

        $thirtyDays = PageView::where('viewed_at', '>=', $thirtyDaysAgo)->count();
        $previousThirtyDays = PageView::whereBetween('viewed_at', [$previousStart, $previousEnd])->count();
        $uniqueVisitors = PageView::where('viewed_at', '>=', $thirtyDaysAgo)->distinct()->count('visitor_hash');
        $inquiriesThirtyDays = Inquiry::where('created_at', '>=', $thirtyDaysAgo)->count();

        $dailyRows = PageView::query()
            ->where('viewed_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $trend = collect(CarbonPeriod::create($now->copy()->subDays(6), $now))->map(function ($date) use ($dailyRows) {
            $day = $date->format('Y-m-d');
            return ['date' => $date->format('d.m.'), 'total' => (int) ($dailyRows[$day] ?? 0)];
        });

        return [
            'available' => true,
            'today' => PageView::whereDate('viewed_at', $now->toDateString())->count(),
            'seven_days' => PageView::where('viewed_at', '>=', $now->copy()->subDays(6)->startOfDay())->count(),
            'thirty_days' => $thirtyDays,
            'unique_thirty_days' => $uniqueVisitors,
            'growth' => $previousThirtyDays > 0 ? round((($thirtyDays - $previousThirtyDays) / $previousThirtyDays) * 100, 1) : ($thirtyDays > 0 ? 100 : 0),
            'conversion' => $uniqueVisitors > 0 ? round(($inquiriesThirtyDays / $uniqueVisitors) * 100, 1) : 0,
            'trend' => $trend,
            'popular_pages' => PageView::where('viewed_at', '>=', $thirtyDaysAgo)->select('path', DB::raw('COUNT(*) as total'))->groupBy('path')->orderByDesc('total')->limit(8)->get(),
            'devices' => PageView::where('viewed_at', '>=', $thirtyDaysAgo)->select('device', DB::raw('COUNT(*) as total'))->groupBy('device')->orderByDesc('total')->get(),
            'languages' => PageView::where('viewed_at', '>=', $thirtyDaysAgo)->whereNotNull('locale')->select('locale', DB::raw('COUNT(*) as total'))->groupBy('locale')->orderByDesc('total')->get(),
            'sources' => PageView::where('viewed_at', '>=', $thirtyDaysAgo)->selectRaw("COALESCE(referrer_host, 'Direktno') as source, COUNT(*) as total")->groupBy('source')->orderByDesc('total')->limit(6)->get(),
        ];
    }
}
