<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanStockController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.laporan-stock.index', [
            'title' => 'Laporan Stock',
            'user' => $user,
        ]);
    }
}
