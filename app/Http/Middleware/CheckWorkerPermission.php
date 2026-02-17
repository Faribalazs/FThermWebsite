<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkerPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth('worker')->user();
        
        if (!$user) {
            return redirect()->route('worker.login');
        }
        
        // Check if worker has the required permission
        if (!$user->hasPermission($permission)) {
            abort(403, 'Nemate dozvolu za pristup ovoj stranici.');
        }
        
        return $next($request);
    }
}
