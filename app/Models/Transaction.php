<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'account_number',
        'beneficiary_user_id',
        'beneficiary_account_number',
        'description',
        'type',
        'amount',
        'currency'
    ];
}
