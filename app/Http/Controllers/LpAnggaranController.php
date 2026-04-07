<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LpAnggaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.lp-anggaran.index', [
            'title' => 'Laporan Anggaran',
            'user' => $user,
        ]);
    }
}
