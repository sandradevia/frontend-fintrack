<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;

class BapSisadanaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }
        $dapur = Dapur::first();

        return view('admin.bap-sisadana.index', [
            'title' => 'BAP Sisa Dana',
            'dapur' => $dapur
        ]);
    }
}
