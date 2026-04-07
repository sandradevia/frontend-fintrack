<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;

class DapurController extends Controller
{
    public function pilih($id)
    {
        session([
            'dapur_id' => $id
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}