<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login', ['heading' => 'Admin Login', 'route' => route('admin.login')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            /** @var \App\Models\User $user */
            $user = Auth::guard('admin')->user();

            if (!$user->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            if (!$user->isAdmin()) {
                 Auth::guard('admin')->logout();
                 return back()->withErrors(['email' => 'Access denied. Admins only.']);
            }

            // Regenerate session AFTER validation
            $request->session()->regenerate();
            
            // Store a flag to indicate which guard this user should use
            $request->session()->put('auth_guard', 'admin');
            
            // Save session immediately to ensure it persists
            $request->session()->save();
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        
        // Clear the auth guard flag
        $request->session()->forget('auth_guard');
        
        // Regenerate session to prevent fixation attacks
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
