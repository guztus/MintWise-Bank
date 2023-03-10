<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'number',
        'currency',
        'credit_limit'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
