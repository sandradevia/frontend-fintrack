<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AnggaranBahan;
use App\Models\KategoriPenerima;

class DetailAnggaranBahan extends Model
{
    protected $table = 'detail_anggaran_bahan';

    protected $fillable = [
        'anggaran_bahan_id',
        'kategori_penerima_id',
        'jumlah',
    ];

    public function anggaranBahan()
    {
        return $this->belongsTo(
            AnggaranBahan::class,
            'anggaran_bahan_id'
        );
    }

    public function kategoriPenerima()
    {
        return $this->belongsTo(
            KategoriPenerima::class,
            'kategori_penerima_id'
        );
    }
}