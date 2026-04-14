<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;

class AwalBukuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapur = Dapur::all();

        return view('admin.awal-buku.saldo', [
            'title' => 'Saldo Awal Buku',
            'user' => $user,
            'dapur' => $dapur,
        ]);
    }
}
