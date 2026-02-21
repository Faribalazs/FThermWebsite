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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Morate biti prijavljeni.'
                ], 401);
            }
            return redirect()->route('worker.login');
        }

        // Restore session guard flag when re-authenticated via remember token
        if (!$request->session()->has('auth_guard')) {
            $request->session()->put('auth_guard', 'worker');
            $request->session()->save();
        }

        if (!$user->is_active) {
            auth('worker')->logout();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'Vaš nalog je deaktiviran.'
                ], 403);
            }
            return redirect()->route('worker.login')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        if (!$user->isWorker()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'Nemate dozvolu za pristup.'
                ], 403);
            }
            abort(403, 'Unauthorized access');
        }
        
        return $next($request);
    }
}
