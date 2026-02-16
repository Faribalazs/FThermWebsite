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
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::guard('admin')->user();

            if (!$user->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            if (!$user->isAdmin()) { // Assuming isAdmin() checks role or is_admin flag
                 Auth::guard('admin')->logout();
                 return back()->withErrors(['email' => 'Access denied. Admins only.']);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        
        // We do not invalidate session to preserve other guard logins (Worker/User)
        // $request->session()->invalidate(); 
        // $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
