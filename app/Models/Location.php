<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'location_id',
        'location',
        'bin',
        'description',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
