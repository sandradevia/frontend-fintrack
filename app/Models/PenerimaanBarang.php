<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';

    protected $fillable = [
        'barang_id',
        'jumlah',
        'harga_beli',
        'supplier',
        'tanggal_masuk',
        'total_harga',
    ];

    // RELASI → Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // RELASI → Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}