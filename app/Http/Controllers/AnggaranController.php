<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function bahan()
    {
        return view('anggaran.bahan');
    }

    public function operasional()
    {
        return view('anggaran.operasional');
    }

    public function insentif()
    {
        return view('anggaran.insentif');
    }
}
