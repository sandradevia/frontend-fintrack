<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Dapur;

use Spatie\Permission\Traits\HasRoles;
/**
 * @method bool hasRole(string|array|\Spatie\Permission\Models\Role|\Illuminate\Support\Collection $roles, string|null $guard = null)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin') || $this->hasRole('super_admin');
    }

    public function dapur()
    {
        return $this->belongsTo(Dapur::class);
    }
}