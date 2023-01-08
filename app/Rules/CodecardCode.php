<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CodecardCode implements InvokableRule
{
    public function __invoke($attribute, $value, $fail): void
    {
        $codeId = 'code_' . Cache::get('code');

        if ($value != Auth::user()->codeCard->$codeId) {
            $fail('The codecard code is incorrect');
        }
    }
}
