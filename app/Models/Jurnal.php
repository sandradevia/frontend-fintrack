<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\Akun;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'akun_id',
        'debit',
        'kredit',
    ];

    // =====================
    // RELASI KE TRANSAKSI
    // =====================
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // =====================
    // RELASI KE AKUN
    // =====================
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }

    // =====================
    // SCOPE (OPTIONAL TAPI BAGUS)
    // =====================

    public function scopeDebit($query)
    {
        return $query->where('debit', '>', 0);
    }

    public function scopeKredit($query)
    {
        return $query->where('kredit', '>', 0);
    }
}