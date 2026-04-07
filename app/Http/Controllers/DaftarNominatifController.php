<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarNominatifController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.daftar-nominatif.index', [
            'title' => 'Daftar Nominatif',
            'user' => $user,
        ]);
    }
}
