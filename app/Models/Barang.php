<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['nama', 'satuan', 'stok', 'harga_beli', 'dapur_id'];
}