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


        if ($user->hasRole('super_admin')) {

            session([
                'is_superadmin' => true,
            ]);

            return redirect()->route('super.dashboard');
        }


        if ($user->hasRole('admin_yayasan')) {

            session([
                'is_superadmin' => false,
            ]);

            return redirect()->route('yayasan.dashboard');
        }

        // ADMIN DAPUR
        if ($user->hasRole('admin_dapur')) {

            session([
                'is_superadmin' => false,
                'dapur_id' => $user->dapur_id,
                'dapur_nama' => optional($user->dapur)->nama_lembaga,
            ]);

            return redirect()->route('admin.dashboard');
        }

        Auth::logout();

        return back()->withErrors([
            'login' => 'Role user tidak dikenali'
        ]);
    }

    return back()->withErrors([
        'login' => 'Username atau password salah'
    ]);
}

    /**
     * 👑 PILIH DAPUR KHUSUS SUPER ADMIN
     */
    public function pilihDapur($id)
    {
        $dapur = Dapur::findOrFail($id);

        session([
            'is_superadmin' => false,
            'dapur_id' => $dapur->id,
            'dapur_nama' => $dapur->nama_lembaga
        ]);

        return redirect()->route('admin.dashboard');
    }


    public function dapurUtama()
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403);
        }

        session([
            'is_superadmin' => true,
            'dapur_id' => null,
            'dapur_nama' => 'Dapur Utama'
        ]);

        return redirect()->route('super.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}