<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dapur;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'pekerjaan_id',
        'dapur_id',
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}