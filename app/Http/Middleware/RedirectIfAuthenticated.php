<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * This middleware ONLY checks the specific guard passed as parameter.
     * It does NOT check other guards, allowing multi-guard authentication.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $guard
     */
    public function handle(Request $request, Closure $next, string $guard = null): Response
    {
        // Only check if the user is authenticated on the SPECIFIC guard
        if (Auth::guard($guard)->check()) {
            /** @var \App\Models\User $user */
            $user = Auth::guard($guard)->user();
            
            // Redirect based on the specific guard that is authenticated
            if ($guard === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            if ($guard === 'worker') {
                // Check permissions for worker
                if (empty($user->permissions)) {
                    return redirect()->route('worker.no-permissions');
                }
                if ($user->hasPermission('dashboard')) {
                    return redirect()->route('worker.dashboard');
                }
                return redirect()->route('worker.no-permissions');
            }
            
            // Default fallback
            return redirect()->route('home');
        }

        // User is NOT authenticated on this specific guard, allow them to proceed
        return $next($request);
    }
}
