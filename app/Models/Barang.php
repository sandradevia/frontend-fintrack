<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StokAwal;

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
}