<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeLocale = $request->route('locale');
        $queryLocale = $request->get('lang');
        $locale = $routeLocale ?? $queryLocale ?? config('app.locale');
        $locale = $locale === 'rs' ? 'sr' : $locale;

        if (in_array($locale, ['en', 'sr', 'hu'])) {
            app()->setLocale($locale);
            \Illuminate\Support\Facades\URL::defaults(['locale' => $locale]);

            if (! $routeLocale && $queryLocale) {
                session(['locale' => $locale]);
            }
        }

        return $next($request);
    }
}
