<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarNominatif extends Model
{
    protected $table = 'daftar_nominatif';

    protected $fillable = [
        'dapur_id',
        'anggota_id',
        'tanggal',
        'no_bukti',
        'honor',
        'dana_sehat',
        'transport',
        'pajak',
        'total',
    ];

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function kehadiranNominatif()
    {
        return $this->hasMany(KehadiranNominatif::class, 'daftar_nominatif_id');
    }
}