<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtendRememberedSession
{
    /**
     * Extend session lifetime for users who checked "remember me".
     * 
     * When a user is authenticated via the remember token cookie,
     * extend the session to 30 days so they stay logged in
     * across webview/browser restarts without needing to re-login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = $request->session()->get('auth_guard');

        if ($guard && auth($guard)->check() && auth($guard)->viaRemember()) {
            config(['session.lifetime' => 43200]); // 30 days
        }

        // Also extend for workers who have remember_token set in their cookie
        if ($guard === 'worker' && auth('worker')->check()) {
            $user = auth('worker')->user();
            if ($user && $user->getRememberToken()) {
                config(['session.lifetime' => 43200]); // 30 days
            }
        }

        return $next($request);
    }
}
