<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_1',
        'code_2',
        'code_3',
        'code_4',
        'code_5',
        'code_6',
        'code_7',
        'code_8',
        'code_9',
        'code_10',
        'code_11',
        'code_12'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
