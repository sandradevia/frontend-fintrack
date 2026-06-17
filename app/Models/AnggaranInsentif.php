<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranInsentif extends Model
{
    protected $table = 'anggaran_insentif';

    protected $fillable = [
        'dapur_id',
        'anggaran_bahan_id',
        'tanggal',
        'harga_satuan',
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

    public function bahan()
    {
        return $this->belongsTo(
            AnggaranBahan::class,
            'anggaran_bahan_id'
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