<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    const ROOT_ID = "00000000-0000-0000-0000-000000000000";

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'order',
    ];

    protected $with = [
        'children'
    ];

    public static array $filterable = [
        'name',
    ];

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Team::class, 'parent_id', 'id');

    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function managers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->users()->wherePivot('is_manager', true)->get();
    }
}
