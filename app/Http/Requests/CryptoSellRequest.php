<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CryptoSellRequest extends CryptoSaleRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        Cache::rememberForever('latestPrice', function () {
            return $this->cryptoService->getSingle($this->symbol)->getPrice();
        });

        $amount = Auth::user()->wallet->assets->where('symbol', $this->symbol)->first()
            ? Auth::user()->wallet->assets->where('symbol', $this->symbol)->first()->amount
            : null;
        $maxAmount = (string)$amount;

        $rules = parent::rules();
        $rules ['symbol'] = array_merge(
            $rules['symbol'],
            [
                'in:' . Auth::user()->wallet->assets->pluck('symbol')->implode(',', 'symbol'),
            ]
        );
        $rules ['assetAmount'] = array_merge(
            $rules['assetAmount'],
            [
                'max:' . $maxAmount,
            ],
        );

        return $rules;
    }

    public function messages(): array
    {
        $messages = parent::messages();
        $messages [] =
            [
                'symbol.in' => 'You do not own this asset.',
            ];
        return $messages;
    }
}
