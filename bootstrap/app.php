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
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'worker' => \App\Http\Middleware\WorkerMiddleware::class,
            'worker.permission' => \App\Http\Middleware\CheckWorkerPermission::class,
        ]);

        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            if ($request->is('worker') || $request->is('worker/*')) {
                return route('worker.login');
            }
            return route('login');
        });

        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            // Check session flag for which guard was used to login
            $authGuard = $request->session()->get('auth_guard', null);
            
            if ($authGuard === 'worker' && auth('worker')->check()) {
                $user = auth('worker')->user();
                // Check if worker has any permissions
                if (empty($user->permissions)) {
                    return route('worker.no-permissions');
                }
                // Redirect to dashboard if they have dashboard permission, otherwise to no-permissions
                if ($user->hasPermission('dashboard')) {
                    return route('worker.dashboard');
                }
                return route('worker.no-permissions');
            }
            
            if ($authGuard === 'admin' && auth('admin')->check()) {
                return route('admin.dashboard');
            }
            
            // Fallback: get user and check their role
            $user = auth('worker')->user() ?? auth('admin')->user() ?? auth('web')->user();
            
            if ($user) {
                if ($user->role === 'worker') {
                    // Check if worker has any permissions
                    if (empty($user->permissions)) {
                        return route('worker.no-permissions');
                    }
                    // Redirect to dashboard if they have dashboard permission
                    if ($user->hasPermission('dashboard')) {
                        return route('worker.dashboard');
                    }
                    return route('worker.no-permissions');
                }
                
                if ($user->role === 'admin' || $user->is_admin) {
                    return route('admin.dashboard');
                }
            }
            
            return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
