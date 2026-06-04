<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAnggaranBahan extends Model
{
    protected $table = 'detail_anggaran_bahan';

    protected $fillable = [
        'anggaran_bahan_id',
        'kategori',
        'jumlah',
    ];

    public function anggaranBahan()
    {
        return $this->belongsTo(
            AnggaranBahan::class,
            'anggaran_bahan_id'
        );
    }
}