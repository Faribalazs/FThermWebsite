<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $maintenanceMode = \App\Models\Setting::where('key', 'maintenance_mode')->value('value');

        if ($maintenanceMode === 'true' || $maintenanceMode === '1') {
            
            // Allow admin routes
            if ($request->is('admin/*') || $request->is('admin')) {
                return $next($request);
            }

            // Allow worker routes
            if ($request->is('worker/*') || $request->is('worker')) {
                return $next($request);
            }

            // Allow the maintenance route itself to prevent loop
            if ($request->is('maintenance')) {
                return $next($request);
            }

            // Allow login/logout generally if needed, but requirements say "admin login" which is under admin/*
            // worker login is under worker/*
            // public login? Maybe not.
            
            return redirect()->route('maintenance');
        }

        // If maintenance mode is OFF, but user is trying to access maintenance page, redirect to home
        if ($request->is('maintenance')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
