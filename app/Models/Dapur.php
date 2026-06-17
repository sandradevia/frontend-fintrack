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
        'tempat_pelaporan',
    ];

    // relasi ke periode
    public function periode()
    {
        return $this->hasMany(Periode::class);
    }

    // periode aktif (ambil terbaru)
    public function periodeAktif()
    {
        return $this->hasOne(Periode::class)->latestOfMany();
    }

    public function anggaranBahan()
    {
        return $this->hasMany(AnggaranBahan::class);
    }

    public function user()
{
    return $this->hasOne(User::class, 'dapur_id');
}

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}