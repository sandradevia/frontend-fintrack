<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class StokAwal extends Model
{
    protected $table = 'stok_awal';

    public $timestamps = false;

    protected $fillable = [
        'barang_id',
        'dapur_id',
        'jumlah',
        'harga_beli_awal'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function stok()
{
    return $this->hasMany(StokBarang::class, 'barang_id');
}
}