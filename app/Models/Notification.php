<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'dapur_id',
        'title',
        'message',
        'type',
        'is_read'
    ];

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}