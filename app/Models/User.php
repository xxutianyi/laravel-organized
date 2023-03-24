<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasUuids, HasFactory, Notifiable, HasRoles;

    const ROOT_ID = "00000000-0000-0000-0000-000000000000";
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'mobile',
        'email',
        'password',
        'order'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static array $filterable = [
        'name',
        'mobile',
        'email',
    ];

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
