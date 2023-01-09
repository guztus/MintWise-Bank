<?php

namespace App\Http\Requests;

use App\Rules\CodecardCode;
use Illuminate\Foundation\Http\FormRequest;

class BalanceTransferRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $payerAccount = auth()->user()->accounts->where('number', $this->get('payerAccountNumber'))->first();

        return ([
            'code' =>
                [
                    'required',
                    'numeric',
                    new CodecardCode
                ],
            'payerAccountNumber' =>
                [
                    'required',
                    'exists:accounts,number',
                    'in:' . auth()->user()->accounts->pluck('number')->implode(',')
                ],
            'beneficiaryAccountNumber' =>
                [
                    'required',
                    'different:payerAccountNumber',
                    'min:10'
                ],
            'amount' =>
                [
                    'required',
                    'numeric',
                    'min:0.01',
                    'max:' . $payerAccount->balance / 100
                ],
            'description' =>
                [
                    'required',
                    'string'
                ]
        ]);
    }
}
