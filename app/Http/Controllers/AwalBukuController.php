<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;

class AwalBukuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapur = Dapur::find($user->dapur_id);

        if (!$dapur) {
            abort(404, 'Data dapur tidak ditemukan');
        }

        $akuns = Akun::whereHas('jurnal.transaksi', function ($q) use ($dapur) {
                $q->where('dapur_id', $dapur->id);
            })
            ->orderBy('kode')
            ->get();

        return view('admin.awal-buku.saldo', [
            'title' => 'Saldo Awal Buku',
            'user' => $user,
            'dapur' => $dapur,
            'akuns' => $akuns,
        ]);
    }
}
