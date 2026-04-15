<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StokBarang;

class PengeluaranBarang extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';

    protected $fillable = [
        'barang_id',
        'anggota_id',
        'tanggal_keluar',
        'jumlah',
    ];

    /**
     * Relasi ke tabel barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Relasi ke tabel anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function getTotalAttribute()
{
    return $this->jumlah;
}
public function stok()
{
    return $this->hasOne(StokBarang::class, 'barang_id');
}
}