<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StokAwal;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'satuan',
        'supplier',
        'dapur_id',
    ];

    // RELASI ke stok_awal
    public function stokAwal()
    {
        return $this->hasOne(StokAwal::class);
    }

    // RELASI ke dapur (kalau ada model Dapur)
    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }

    public function stok()
    {
        return $this->hasOne(StokBarang::class, 'barang_id');
    }

    public function penerimaan()
{
    return $this->hasMany(PenerimaanBarang::class, 'barang_id');
}

public function pengeluaran()
{
    return $this->hasMany(PengeluaranBarang::class, 'barang_id');
}
}