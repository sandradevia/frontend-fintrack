<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpTanggungjawabController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.sp-tanggungjawab.index', [
            'title' => 'SP Tanggung Jawab',
            'user' => $user,
        ]);
    }
}
