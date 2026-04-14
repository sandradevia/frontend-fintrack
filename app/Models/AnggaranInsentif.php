<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranInsentif extends Model
{
    protected $table = 'anggaran_insentif';

    protected $fillable = [
        'dapur_id',
        'anggaran_bahan_id',
        'tanggal',
        'harga_satuan',
        'total_rab'
    ];

    // Relasi ke dapur
    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }

    // 🔥 Relasi ke anggaran bahan
    public function bahan()
    {
        return $this->belongsTo(AnggaranBahan::class, 'anggaran_bahan_id');
    }

    // 🔥 Auto hitung total (optional)
    protected static function booted()
    {
        static::saving(function ($model) {
            // kalau nanti ada field jumlah, bisa dikali
            // sementara pakai harga_satuan saja
            $model->total_rab = $model->harga_satuan;
        });
    }
}