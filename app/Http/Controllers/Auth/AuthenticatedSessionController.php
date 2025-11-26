<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ganti redirect default dengan logic role-based
        return redirect()->intended($this->getRoleBasedRedirectUrl($request->user()));
    }
    
    /**
     * Menentukan URL redirect berdasarkan peran (role) pengguna.
     */
    private function getRoleBasedRedirectUrl($user): string
    {
        return match($user->role) {
            'admin' => '/admin',
            'manager' => '/manager',
            'staff' => '/staff',
            'supplier' => '/supplier',
            default => RouteServiceProvider::HOME, // Fallback ke default Breeze
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}