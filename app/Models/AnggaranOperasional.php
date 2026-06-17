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
        'total_rab',
        'status',
        'verified_by',
        'verified_at',
        'catatan_status',
    ];

    public function dapur()
    {
        return $this->belongsTo(
            Dapur::class,
            'dapur_id'
        );
    }

    public function verifier()
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }
}