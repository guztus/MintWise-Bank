<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'symbol',
        'average_cost',
        'amount',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
