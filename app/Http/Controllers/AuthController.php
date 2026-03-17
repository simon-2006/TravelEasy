<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $attributes['role'] = User::ROLE_REISADVISEUR;

        $user = User::create($attributes);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('status_success', 'Account aangemaakt en succesvol ingelogd.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            $redirectRoute = Auth::user()?->canViewAccountOverview()
                ? 'accounts.index'
                : 'home';

            return redirect()
                ->route($redirectRoute)
                ->with('status_success', 'Succesvol ingelogd.');
        }

        return back()
            ->withInput($request->only('login'))
            ->with('status_error', 'Voer de juiste gegevens in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status_success', 'Succesvol uitgelogd.');
    }
}
