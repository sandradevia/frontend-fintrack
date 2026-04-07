<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.pengeluaran-barang.index', [
            'title' => 'Pengeluaran Barang',
            'user' => $user,
        ]);
    }
}
