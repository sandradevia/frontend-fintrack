<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dapur extends Model
{
    protected $table = 'dapur';
    protected $fillable = [
        'nama_lembaga',
        'alamat',
        'nama_kepala_sppg',
        'nama_akuntan',
        'nama_yayasan',
        'ketua_yayasan',
        'nomor_rekening',
        'tanggal_pelaporan',
        'tempat_pelaporan',
        'tahun_anggaran',
        'periode_saat_ini',
        'awal_periode_berikutnya'
    ];

    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    public function periodeAktif()
    {
        return $this->hasOne(Periode::class)->where('is_active', true);
    }

    public function anggaranBahan()
    {
        return $this->hasMany(AnggaranBahan::class);
    }

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}