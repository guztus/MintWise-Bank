<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CodecardCode implements InvokableRule
{
    public function __invoke($attribute, $enteredCode, $fail): void
    {
        session()->reflash();
        $codes = explode(';', Auth::user()->codeCard->codes);

        if ($codes[session()->get('codeNumber') - 1] != $enteredCode) {
            $fail('The codecard code is incorrect');
        }
    }
}
