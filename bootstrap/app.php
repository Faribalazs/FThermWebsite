<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\ExtendRememberedSession::class,
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'worker' => \App\Http\Middleware\WorkerMiddleware::class,
            'worker.permission' => \App\Http\Middleware\CheckWorkerPermission::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            // Check which area the user is trying to access based on URL pattern
            if ($request->is('admin*')) {
                return route('admin.login');
            }
            
            if ($request->is('worker*')) {
                return route('worker.login');
            }
            
            return route('login');
        });

        // Don't use redirectUsersTo - it interferes with multi-guard authentication
        // Each guard will handle its own redirects via the login controllers
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
