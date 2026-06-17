<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnggaranBahan;
use App\Models\AnggaranOperasional;
use App\Models\AnggaranInsentif;

namespace App\Http\Controllers;

class AnggaranController extends Controller
{
    public function bahan()
    {
        return view('admin.anggaran.bahan', [
            'title' => 'Setup Anggaran',
        ]);
    }

    public function operasional()
    {
        return view('admin.anggaran.operasional', [
            'title' => 'Setup Anggaran',
        ]);
    }

    public function insentif()
    {
        return view('admin.anggaran.insentif', [
            'title' => 'Setup Anggaran',
        ]);
    }
}