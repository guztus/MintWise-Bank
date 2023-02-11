<?php

namespace App\Http\Requests;

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

        $rules ['assetAmount'] = array_merge(
            $rules['assetAmount'],
            [
                'max:' . (Auth::user()->wallet->balance) / Cache::get('latestPrice') / 100,
            ]
        );

        return $rules;
    }

    public function messages(): array
    {
        return parent::messages();
    }
}
