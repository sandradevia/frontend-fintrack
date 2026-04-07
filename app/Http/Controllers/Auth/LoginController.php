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
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 👑 SUPER ADMIN
            if ($user->hasRole('super_admin')) {
                return response()->json([
                    'status' => 'success',
                    'role' => 'super_admin'
                ]);
            }

            // 👤 ADMIN
            if ($user->hasRole('admin')) {

                session([
                    'dapur_id' => $user->dapur_id
                ]);

                return response()->json([
                    'status' => 'success',
                    'role' => 'admin',
                    'redirect' => route('admin.dashboard')
                ]);
            }

            Auth::logout();

            return response()->json([
                'status' => 'error',
                'message' => 'Role tidak dikenali'
            ], 403);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Username atau password salah'
        ], 401);
    }

    public function pilihDapur($id)
    {
        session([
            'dapur_id' => $id
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}