<?php

namespace App\Http\Controllers\Worker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::guard('worker')->check()) {
            return redirect()->route('worker.dashboard');
        }
        return view('auth.login', ['heading' => 'Worker Login', 'route' => route('worker.login')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('worker')->attempt($credentials, $request->boolean('remember'))) {
            /** @var \App\Models\User $user */
            $user = Auth::guard('worker')->user();

            if (!$user->is_active) {
                Auth::guard('worker')->logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            if (!$user->isWorker()) { 
                 Auth::guard('worker')->logout();
                 return back()->withErrors(['email' => 'Access denied. Workers only.']);
            }

            // Regenerate session AFTER validation to prevent session fixation
            $request->session()->regenerate();
            
            // Store a flag to indicate which guard this user should use
            $request->session()->put('auth_guard', 'worker');
            
            // When "remember me" is checked, extend the session cookie lifetime
            // so the session persists across webview/browser restarts (30 days)
            if ($request->boolean('remember')) {
                config(['session.lifetime' => 43200]); // 30 days in minutes
            }
            
            // Save session immediately to ensure it persists
            $request->session()->save();
            
            // Determine where to redirect based on permissions
            if (empty($user->permissions)) {
                return redirect()->route('worker.no-permissions');
            }
            
            if ($user->hasPermission('dashboard')) {
                return redirect()->route('worker.dashboard');
            }
            
            // If no dashboard permission, redirect to no-permissions page
            return redirect()->route('worker.no-permissions');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('worker')->logout();
        
        // Clear the auth guard flag
        $request->session()->forget('auth_guard');
        
        // Regenerate session to prevent fixation attacks
        $request->session()->regenerateToken();

        return redirect()->route('worker.login');
    }
}
