<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.signin', ['title' => 'Sign In']);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Support: Spatie role ATAU kolom role
            $isSuperAdmin =
                (method_exists($user, 'hasRole') && call_user_func([$user, 'hasRole'], 'super_admin'))
                || (($user->role ?? null) === 'super_admin');

            return $isSuperAdmin
                ? redirect()->route('super.dashboard')
                : redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}