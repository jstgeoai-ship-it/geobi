<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // validasi + attempt login (dari Breeze default)
            $request->authenticate();

            // regenerate session untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended(route('home'));

        } catch (\Illuminate\Validation\ValidationException $e) {

            // kirim error manual agar login.blade tidak crash
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ])->onlyInput('email');
        }
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}