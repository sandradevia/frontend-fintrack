<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnggaranBahan;
use App\Models\AnggaranOperasional;
use App\Models\AnggaranInsentif;

class AnggaranController extends Controller
{
    public function bahan(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'bahan');

        $items = collect();
        $total = 0;
        $count = 0;

        // ================= BAHAN =================
        if ($tab == 'bahan') {
            $items = AnggaranBahan::with('dapur')->get();
            $total = $items->sum('total_rab');
        }

        // ================= OPERASIONAL =================
        elseif ($tab == 'operasional') {
            $items = AnggaranOperasional::with('dapur')->get();
            $total = $items->sum('total_rab');
        }

        // ================= INSENTIF =================
        elseif ($tab == 'insentif') {
            $items = AnggaranInsentif::with(['dapur','bahan'])->get();
            $total = $items->sum('total_rab');
        }

        $count = $items->count();
        $totalGlobalRab = 0;

$totalGlobalRab += AnggaranBahan::sum('total_rab');
$totalGlobalRab += AnggaranOperasional::sum('total_rab');
$totalGlobalRab += AnggaranInsentif::sum('total_rab');
        $summary = [
        'bahan' => [
            'count' => AnggaranBahan::count(),
            'total' => AnggaranBahan::sum('total_rab'),
        ],
        'operasional' => [
            'count' => AnggaranOperasional::count(),
            'total' => AnggaranOperasional::sum('total_rab'),
        ],
        'insentif' => [
            'count' => AnggaranInsentif::count(),
            'total' => AnggaranInsentif::sum('total_rab'),
        ],
    ];

        return view('admin.anggaran.bahan', [
            'title' => 'Setup Anggaran',
            'user' => $user,
            'activeTab' => $tab,
            'items' => $items,
            'total' => $total,
            'count' => $count,
            'summary' => $summary,
            'totalGlobalRab' => $totalGlobalRab,
        ]);
    }
}