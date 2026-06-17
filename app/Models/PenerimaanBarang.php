<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
        'jumlah',
        'harga_beli',
        'gambar',
        'status',
    ];

    protected $appends = ['gambar_url']; // ⭐ INI YANG KURANG

    public function getGambarUrlAttribute()
{
    if (!$this->gambar) return null;

    // kalau sudah URL lengkap
    if (str_starts_with($this->gambar, 'http')) {
        return $this->gambar;
    }

    // kalau path lokal (string biasa)
    return asset($this->gambar);
}

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function getTotalHargaAttribute()
    {
        return $this->jumlah * $this->harga_beli;
    }
}