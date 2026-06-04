<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akuns';

    protected $fillable = [
        'kode',
        'nama_akun',
    ];

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'akun_id');
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}