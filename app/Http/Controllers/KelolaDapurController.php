<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelolaDapurController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('super.kelola-dapur.index', [
            'title' => 'Kelola Dapur',
            'user' => $user,
        ]);
    }
}
