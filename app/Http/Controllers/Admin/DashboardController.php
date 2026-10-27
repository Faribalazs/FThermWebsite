<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\PageView;
use App\Models\Product;
use App\Models\Service;
use Carbon\CarbonImmutable;
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
            'unique_thirty_days' => 0, 'growth' => null, 'weekly_growth' => null, 'conversion' => null,
            'trend' => collect(), 'popular_pages' => collect(), 'devices' => collect(),
            'languages' => collect(), 'sources' => collect(), 'timezone' => config('analytics.timezone'),
        ];

        if (! Schema::hasTable('page_views')) {
            return $empty;
        }

        $now = CarbonImmutable::now(config('analytics.timezone'));
        // Stored timestamps use the application timezone; reporting uses local calendar days.
        $storedTime = fn (CarbonImmutable $date) => $date->setTimezone(config('app.timezone'))->toDateTimeString();
        $thirtyDaysAgo = $now->subDays(29)->startOfDay();
        $sevenDaysAgo = $now->subDays(6)->startOfDay();
        $currentViews = PageView::whereBetween('viewed_at', [$storedTime($thirtyDaysAgo), $storedTime($now)]);

        $thirtyDays = (clone $currentViews)->count();
        // Compare through the same local time, since today is still in progress.
        $previousThirtyDays = PageView::whereBetween('viewed_at', [
            $storedTime($thirtyDaysAgo->subDays(30)), $storedTime($now->subDays(30)),
        ])->count();
        $previousSevenDays = PageView::whereBetween('viewed_at', [
            $storedTime($sevenDaysAgo->subDays(7)), $storedTime($now->subDays(7)),
        ])->count();
        $uniqueVisitors = (clone $currentViews)->distinct()->count('visitor_hash');
        $inquiriesThirtyDays = Inquiry::withTrashed()
            ->whereBetween('created_at', [$storedTime($thirtyDaysAgo), $storedTime($now)])->count();

        $trend = collect(range(6, 0))->map(function ($daysAgo) use ($now, $storedTime, $currentViews) {
            $day = $now->subDays($daysAgo)->startOfDay();

            return [
                'date' => $day->format('d.m.'),
                'total' => (clone $currentViews)
                    ->where('viewed_at', '>=', $storedTime($day))
                    ->where('viewed_at', '<', $storedTime($day->addDay()))->count(),
            ];
        });
        $sevenDays = $trend->sum('total');
        $growth = fn (int $current, int $previous) => $previous > 0
            ? round((($current - $previous) / $previous) * 100, 1)
            : null;

        return [
            'available' => true,
            'today' => $trend->last()['total'],
            'seven_days' => $sevenDays,
            'thirty_days' => $thirtyDays,
            'unique_thirty_days' => $uniqueVisitors,
            'growth' => $growth($thirtyDays, $previousThirtyDays),
            'weekly_growth' => $growth($sevenDays, $previousSevenDays),
            'conversion' => $uniqueVisitors > 0 ? round(($inquiriesThirtyDays / $uniqueVisitors) * 100, 1) : null,
            'timezone' => $now->timezoneName,
            'trend' => $trend,
            'popular_pages' => (clone $currentViews)->select('path', DB::raw('COUNT(*) as total'))->groupBy('path')->orderByDesc('total')->limit(8)->get(),
            'devices' => (clone $currentViews)->select('device', DB::raw('COUNT(*) as total'))->groupBy('device')->orderByDesc('total')->get(),
            'languages' => (clone $currentViews)->whereNotNull('locale')->select('locale', DB::raw('COUNT(*) as total'))->groupBy('locale')->orderByDesc('total')->get(),
            'sources' => (clone $currentViews)->selectRaw("COALESCE(referrer_host, 'Direktno') as source, COUNT(*) as total")->groupBy('source')->orderByDesc('total')->limit(6)->get(),
        ];
    }
}
