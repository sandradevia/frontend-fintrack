<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KehadiranNominatif extends Model
{
    protected $table = 'kehadiran_nominatif';

    protected $fillable = [
        'daftar_nominatif_id',
        'tanggal',
        'honor_harian',
    ];

    public function nominatif()
    {
        return $this->belongsTo(DaftarNominatif::class, 'daftar_nominatif_id');
    }
    public function daftarNominatif()
    {
        return $this->belongsTo(DaftarNominatif::class, 'daftar_nominatif_id');
    }
}