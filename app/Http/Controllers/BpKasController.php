<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BpKasController extends Controller
{
    public function index()
    {
        // Bisa kirim data default jika ingin
        $data = [
            'lembaga' => 'Yayasan Contoh Indonesia',
            'periode' => 'Januari 2026',
            'transaksi' => [
                [
                    'id' => 1,
                    'tanggal' => '2026-01-01',
                    'no_bukti' => 'TRX-001',
                    'uraian' => 'Pembelian bahan',
                    'debet' => 500000,
                    'kredit' => 0,
                    'jenis' => 'Kas',
                    'keterangan' => 'Awal',
                ]
            ]
        ];

        return view('admin.bp-kas.index', compact('data'));
    }
}