<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranOperasional extends Model
{
    protected $table = 'anggaran_operasional';

    protected $fillable = [
        'dapur_id',
        'tanggal',
        'keterangan',
        'total_rab'
    ];

    // Relasi ke dapur
    public function dapur()
    {
        return $this->belongsTo(Dapur::class, 'dapur_id');
    }
}