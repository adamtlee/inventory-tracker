<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'asset_id',
        'item',
        'item_code',
        'belongs_to',
        'condition',
        'comments',
        'location_id',
    ];

    protected $casts = [
        'date_checked_out' => 'datetime',
        'date_returned' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function currentCheckout(): HasMany
    {
        return $this->hasMany(Checkout::class)->whereNull('date_returned');
    }

    public function isCheckedOut(): bool
    {
        return $this->currentCheckout()->exists();
    }
}
