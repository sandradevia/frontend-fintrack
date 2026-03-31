<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggaranController extends Controller
{
    public function bahan(Request $request)
    {
        $user = Auth::user();

        // Mengambil parameter 'tab' dari URL, jika tidak ada maka defaultnya 'bahan'
        $tab = $request->query('tab', 'bahan');

        // Logika untuk mengisi data tabel berdasarkan tab yang dipilih
        $items = [];

        if ($tab == 'bahan') {
            $items = [
                ['no' => 1, 'nama' => 'Beras Premium', 'satuan' => 'Kg', 'saldo' => 500, 'harga' => '14.000'],
                ['no' => 2, 'nama' => 'Minyak Goreng', 'satuan' => 'Liter', 'saldo' => 100, 'harga' => '18.000'],
                ['no' => 3, 'nama' => 'Telur Ayam', 'satuan' => 'Butir', 'saldo' => 1000, 'harga' => '2.000'],
            ];
        } elseif ($tab == 'operasional') {
            $items = [
                ['no' => 1, 'nama' => 'Listrik & Air', 'satuan' => 'Bulan', 'saldo' => 1, 'harga' => '2.500.000'],
                ['no' => 2, 'nama' => 'Pemeliharaan Gedung', 'satuan' => 'Kegiatan', 'saldo' => 1, 'harga' => '5.000.000'],
            ];
        } elseif ($tab == 'insentif') {
            $items = [
                ['no' => 1, 'nama' => 'Insentif Masak', 'satuan' => 'Orang', 'saldo' => 5, 'harga' => '500.000'],
                ['no' => 2, 'nama' => 'Uang Kebersihan', 'satuan' => 'Bulan', 'saldo' => 1, 'harga' => '300.000'],
            ];
        }

        return view('admin.anggaran.bahan', [
            'title' => 'Setup Anggaran',
            'user' => $user,
            'activeTab' => $tab, 
            'items' => $items    
        ]);
    }
}