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
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_pelaporan',
        'tempat_pelaporan',
        'is_active',
    ];

    // Relasi ke Dapur
    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}