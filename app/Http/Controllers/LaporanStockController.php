<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class LaporanStockController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $items = Barang::all();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.laporan-stock.index', [
            'title' => 'Laporan Stock',
            'user' => $user,
            'items' => $items,
        ]);
    }
}
