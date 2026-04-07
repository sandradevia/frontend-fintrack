<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BpinsentifController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.bp-insentif.index', [
            'title' => 'Saldo Awal Buku',
            'user' => $user,
        ]);
    }
}
