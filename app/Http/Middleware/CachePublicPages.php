<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CachePublicPages
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $routeName = $request->route()?->getName();
        $publicRoutes = [
            'home',
            'about',
            'shop.index',
            'shop.show',
            'services.show',
            'local-seo.air-conditioning',
            'local-seo.heat-pumps',
            'references.index',
            'references.show',
            'sitemap',
            'llms',
        ];
        $shopDependentRoutes = ['home', 'shop.index', 'shop.show', 'sitemap', 'llms'];

        // These responses change when the catalog switch changes. Storing an enabled
        // response could keep products visible after an administrator disables it.
        if ($request->isMethod('GET') && in_array($routeName, $shopDependentRoutes, true)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

            return $response;
        }

        if (
            $request->isMethod('GET')
            && in_array($routeName, $publicRoutes, true)
            && $response->isSuccessful()
            && ! session()->has('contact_success')
            && ! session()->has('errors')
        ) {
            $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=1800, stale-while-revalidate=60');
        }

        return $response;
    }
}
