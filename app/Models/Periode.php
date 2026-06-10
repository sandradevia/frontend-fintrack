<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode'; // sesuai nama tabel

    protected $fillable = [
        'dapur_id',
        'tahun_anggaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_pelaporan',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_pelaporan' => 'string',
        'is_active' => 'boolean',
    ];

    // Relasi ke Dapur
    public function dapur()
    {
    return $this->belongsTo(Dapur::class);    
    }

    public function daftarNominatif()
    {
        return $this->hasMany(DaftarNominatif::class, 'periode_id');
    }
}
    