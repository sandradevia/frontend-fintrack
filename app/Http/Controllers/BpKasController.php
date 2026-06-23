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

    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapurId = $request->dapur_id;

        // ==========================
        // BASE TRANSAKSI QUERY
        // ==========================
        $query = Transaksi::orderBy('tanggal', 'asc');

        if ($user->role !== 'super_admin') {
            $query->where('dapur_id', $user->dapur_id);
        } else {
            if ($dapurId) {
                $query->where('dapur_id', $dapurId);
            }
        }

        $transaksi = $query->get()->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'no_bukti' => $item->no_bukti,
                'uraian'   => $item->uraian,
                'debet'    => $item->debet,
                'kredit'   => $item->kredit,
            ];
        });

        // ==========================
        // DAPUR (fallback super admin)
        // ==========================
        $dapur = $user->role === 'super_admin'
            ? ($dapurId ? Dapur::find($dapurId) : Dapur::first())
            : Dapur::find($user->dapur_id);

        // ==========================
        // PERIODE (per dapur penting!)
        // ==========================
        $periodeQuery = Periode::where('is_active', true);

        if ($user->role !== 'super_admin') {
            $periodeQuery->where('dapur_id', $user->dapur_id);
        } else {
            if ($dapurId) {
                $periodeQuery->where('dapur_id', $dapurId);
            }
        }

        $periode = $periodeQuery->first();

        // ==========================
        // FORMAT PERIODE TEXT
        // ==========================
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

        // ==========================
        // LIST DAPUR UNTUK SUPER ADMIN
        // ==========================
        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        return view('admin.bp-kas.index', [
            'title' => 'BP Kas',
            'dapur' => $dapur,
            'user' => $user,
            'data' => [
                'transaksi' => $transaksi
            ],
            'periode' => $periode,
            'periodeText' => $periodeText,
            'dapurList' => $dapurList,
            'selectedDapur' => $dapurId,
        ]);
    }
}