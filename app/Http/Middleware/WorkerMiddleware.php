<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('worker')->user();

        if (!$user) {
             return redirect()->route('worker.login');
        }

        if (!$user->is_active) {
            auth('worker')->logout();
            return redirect()->route('worker.login')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        if (!$user->isWorker()) {
             abort(403, 'Unauthorized access');
        }
        
        return $next($request);
    }
}
