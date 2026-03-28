<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman admin.');
        }

        return view('pages.dashboard.admin', [
            'title' => 'Dashboard Admin',
        ]);
    }

    public function superAdmin()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman super admin.');
        }

        return view('pages.dashboard.super_admin', [
            'title' => 'Dashboard Super Admin',
        ]);
    }
}
