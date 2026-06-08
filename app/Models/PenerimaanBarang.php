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
        'tanggal_masuk',
        'jumlah',
        'harga_beli',
        'gambar',
        'status',

    ];

    // RELASI: barang_masuks -> barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // OPTIONAL: accessor total harga (tidak disimpan di DB)
    public function getTotalHargaAttribute()
    {
        return $this->jumlah * $this->harga_beli;
    }
}