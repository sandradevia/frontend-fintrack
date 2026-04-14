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
        'total_rab'
    ];

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}
