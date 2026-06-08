<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dapur;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;
use Carbon\Carbon;

class BpKasController extends Controller
{
    public function index()
    {
        $dapur = Dapur::first();
        $user = Auth::user();

        $transaksi = Transaksi::where('dapur_id', $user->dapur_id)
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'no_bukti' => $item->no_bukti,
                    'uraian' => $item->uraian,
                    'debet' => $item->debet,
                    'kredit' => $item->kredit,
                ];
            });

        $data = [
            'transaksi' => $transaksi
        ];

        $periode = Periode::where('dapur_id', $user->dapur_id)
            ->where('is_active', true)
            ->first();

        $periodeText = '-';

        if ($periode) {
            $mulai = Carbon::parse($periode->tanggal_mulai);
            $selesai = Carbon::parse($periode->tanggal_selesai);

            if ($mulai->format('F Y') == $selesai->format('F Y')) {
                $periodeText = $mulai->format('j') . ' - ' .
                    $selesai->translatedFormat('j F Y');
            } else {
                $periodeText = $mulai->translatedFormat('j F Y') . ' - ' .
                    $selesai->translatedFormat('j F Y');
            }
        }

        return view('admin.bp-kas.index', [
            'title' => 'BP Kas',
            'dapur' => $dapur,
            'user' => $user,
            'data' => $data,
            'periode' => $periode,
            'periodeText' => $periodeText,
        ]);
    }
}