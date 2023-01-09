<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CryptoSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'symbol' =>
                [
                    'required',
                ],
            'payerAccountNumber' =>
                [
                    'required',
                    'exists:accounts,number',
                    'in:' . Auth::user()->accounts->pluck('number')->implode(','),
                ],
            'assetAmount' =>
                [
                    'required',
                    'numeric',
                ],
        ];
    }
}
