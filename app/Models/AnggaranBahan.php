<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranBahan extends Model
{
    protected $table = 'anggaran_bahan';

    protected $fillable = [
        'dapur_id',
        'tanggal',
        'jumlah_paket',
        'harga_satuan',
        'total_rab',
        'harga_satuan_2',
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

    public function details()
    {
        return $this->hasMany(
            DetailAnggaranBahan::class,
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