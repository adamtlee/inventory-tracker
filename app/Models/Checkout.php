<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    protected $fillable = [
        'checkout_id',
        'asset_id',
        'user_id',
        'date_checked_out',
        'checked_out_by',
        'date_returned',
        'quantity',
        'checkout_comments',
    ];

    protected $casts = [
        'date_checked_out' => 'datetime',
        'date_returned' => 'datetime',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isReturned(): bool
    {
        return !is_null($this->date_returned);
    }
}
