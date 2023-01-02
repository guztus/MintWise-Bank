<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = [
        'account_id',
        'account_number',
        'cardholder_name',
        'type',
        'number',
        'security_code',
        'expiration_date',
        'design',
    ];

    use HasFactory;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
