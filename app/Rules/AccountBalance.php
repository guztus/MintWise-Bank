<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;

class AccountBalance implements InvokableRule
{

    public function __invoke($attribute, $value, $fail)
    {
        if (Auth::user()->accounts->where('number', $value)->first()->balance <= 0) {
            $fail('The account balance is too low.');
        }
    }
}
