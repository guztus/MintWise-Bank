<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeCard extends Model
{
    protected $fillable = [
        'codes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generate(): string {
        $codes = '';
        for ($i=0;$i<config('auth.code_card.code_amount');$i++) {
            $codes.=fake()->numberBetween(10000, 99999);
            if ($i < config('auth.code_card.code_amount') - 1) {
                $codes.=';';
            }
        }
        return $codes;
    }
}
