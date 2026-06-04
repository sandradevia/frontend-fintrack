<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'dapur_id',
        'akun_id',
        'tanggal',
        'no_bukti',
        'uraian',
        'debet',
        'kredit',
        'keterangan',
    ];

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}