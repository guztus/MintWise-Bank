<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'symbol',
        'average_cost_before_decimal',
        'average_cost_after_decimal',
        'amount_before_decimal',
        'amount_after_decimal',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
