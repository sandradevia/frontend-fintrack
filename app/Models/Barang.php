<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StokAwal;
use App\Models\StokBarang;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;
use App\Models\Dapur;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'satuan',
        'supplier',
        'dapur_id',
    ];

    // 🔥 RELASI DAPUR
    public function dapur()
    {
        return $this->belongsTo(Dapur::class, 'dapur_id');
    }

    // 🔥 STOK AWAL
    public function stokAwal()
    {
        return $this->hasOne(StokAwal::class, 'barang_id');
    }

    // 🔥 STOK BERJALAN
    public function stok()
    {
        return $this->hasOne(StokBarang::class, 'barang_id');
    }

    // 🔥 PENERIMAAN
    public function penerimaan()
    {
        return $this->hasMany(PenerimaanBarang::class, 'barang_id');
    }

    // 🔥 PENGELUARAN
    public function pengeluaran()
    {
        return $this->hasMany(PengeluaranBarang::class, 'barang_id');
    }
}