<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CodecardCode implements InvokableRule
{
    public function __invoke($attribute, $enteredCode, $fail): void
    {
        $requiredCode = Session::get('codeNumber');
        Session::forget('codeNumber');
        $codes = explode(';', Auth::user()->codeCard->codes);

        $correctCode = $codes[$requiredCode - 1];

        if ($correctCode != $enteredCode || $correctCode == -1) {
            $fail('The codecard code is incorrect');
        }
    }
}
