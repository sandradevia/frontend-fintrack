<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPenerima extends Model
{
    protected $table = 'kategori_penerima';

    protected $fillable = [
        'nama_kategori',
    ];

    public function detailAnggaran()
    {
        return $this->hasMany(
            DetailAnggaranBahan::class,
            'kategori_penerima_id'
        );
    }
}