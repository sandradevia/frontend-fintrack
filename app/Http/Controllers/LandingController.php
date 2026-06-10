<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landingpage', [
            'title' => 'Selamat Datang di SIKEDA',
        ]);
    }
}
