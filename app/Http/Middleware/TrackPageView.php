<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    private const PUBLIC_ROUTES = [
        'home', 'about', 'shop.index', 'shop.show', 'services.show',
        'local-seo.air-conditioning', 'local-seo.heat-pumps',
        'references.index', 'references.show',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            if (! Schema::hasTable('page_views')) {
                return $response;
            }

            $userAgent = (string) $request->userAgent();
            $referrerHost = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);
            $ownHost = $request->getHost();

            PageView::create([
                'path' => '/'.ltrim($request->path(), '/'),
                'route_name' => $request->route()?->getName(),
                'locale' => $request->route('locale'),
                'visitor_hash' => hash_hmac('sha256', ($request->ip() ?? '').'|'.$userAgent, (string) config('app.key')),
                'device' => $this->device($userAgent),
                'referrer_host' => $referrerHost && $referrerHost !== $ownHost ? mb_substr($referrerHost, 0, 255) : null,
                'viewed_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || ! $response->isSuccessful()) {
            return false;
        }

        if (! in_array($request->route()?->getName(), self::PUBLIC_ROUTES, true)) {
            return false;
        }

        return ! preg_match('/bot|crawl|spider|slurp|preview|facebookexternalhit|whatsapp/i', (string) $request->userAgent());
    }

    private function device(string $userAgent): string
    {
        if (preg_match('/ipad|tablet|kindle|silk/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }
}
