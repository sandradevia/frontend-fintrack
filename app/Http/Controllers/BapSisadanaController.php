<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BapSisadanaController extends Controller
{
    public function index()
    {
        return view('admin.bap-sisadana.index', [
            'title' => 'Saldo Awal Buku',
        ]);
    }
}
