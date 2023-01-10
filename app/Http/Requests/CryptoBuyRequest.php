<?php

namespace App\Http\Requests;

use App\Rules\AccountBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CryptoBuyRequest extends CryptoSaleRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $rules = parent::rules();

        $rules ['payerAccountNumber'] = array_merge(
            $rules['payerAccountNumber'],
            [
                new AccountBalance,
            ]
        );

        $account = Auth::user()->accounts->where('number', $this->payerAccountNumber)->first();
        $rules ['assetAmount'] = array_merge(
            $rules['assetAmount'],
            [
                'max:' . ($account->balance / Cache::get('currencies')[$account->currency]) / Cache::get('latestPrice') / 100,
            ]
        );

        return $rules;
    }

    public function messages(): array
    {
        return parent::messages();
    }
}
