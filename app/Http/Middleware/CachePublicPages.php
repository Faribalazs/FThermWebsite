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
            'references.index',
            'references.show',
            'sitemap',
            'llms',
        ];

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
