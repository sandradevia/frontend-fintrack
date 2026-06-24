<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';
    public $timestamps = false;

    protected $fillable = [
        'barang_id',
        'dapur_id',
        'stok',
        'last_update'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function stokAwal()
{
    return $this->hasMany(StokAwal::class, 'barang_id');
}
}