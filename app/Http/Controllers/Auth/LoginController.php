<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.auth.signin', [
            'title' => 'Sign In',
            'dapur' => Dapur::all()
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 👑 SUPER ADMIN
            if ($user->hasRole('super_admin')) {
                return redirect()->route('signin')
                    ->with('step', 'dapur');
            }

            // 👤 ADMIN
            session([
                'dapur_id' => $user->dapur_id
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function pilihDapur($id)
    {
        session([
            'dapur_id' => $id
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }

    // public function showPilihDapur()
    // {
    //     return view('pages.auth.pilih-dapur', [
    //         'dapur' => Dapur::all()
    //     ]);
    // }
}