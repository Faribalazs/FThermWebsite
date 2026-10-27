<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function updateEmail(Request $request): RedirectResponse
    {
        $admin = $request->user('admin');
        $validated = $request->validateWithBag('adminEmail', [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($admin->id)],
            'current_password' => ['required', 'string', 'current_password:admin'],
        ], [
            'email.required' => 'Unesite email adresu.',
            'email.email' => 'Unesite ispravnu email adresu.',
            'email.max' => 'Email adresa može imati najviše 255 karaktera.',
            'email.unique' => 'Ova email adresa već pripada drugom nalogu.',
            'current_password.required' => 'Unesite trenutnu lozinku da potvrdite promenu.',
            'current_password.current_password' => 'Trenutna lozinka nije ispravna.',
        ]);

        if ($admin->email !== $validated['email']) {
            $admin->forceFill([
                'email' => $validated['email'],
                'email_verified_at' => null,
                'remember_token' => Str::random(60),
            ])->save();
            $request->session()->regenerate();
        }

        return to_route('admin.settings.index')->with('success', 'Email za prijavu je uspešno sačuvan. Koristite ovu adresu pri sledećoj prijavi.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('adminPassword', [
            'current_password' => ['required', 'string', 'current_password:admin'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Unesite trenutnu lozinku da potvrdite promenu.',
            'current_password.current_password' => 'Trenutna lozinka nije ispravna.',
            'password.required' => 'Unesite novu lozinku.',
            'password.min' => 'Nova lozinka mora imati najmanje 8 karaktera.',
            'password.confirmed' => 'Potvrda nove lozinke se ne podudara.',
            'password.different' => 'Nova lozinka mora se razlikovati od trenutne.',
        ]);

        $request->user('admin')->forceFill([
            'password' => Hash::make($validated['password']),
            'remember_token' => Str::random(60),
        ])->save();
        $request->session()->regenerate();

        return to_route('admin.settings.index')->with('success', 'Lozinka je uspešno promenjena. Koristite novu lozinku pri sledećoj prijavi.');
    }
}
