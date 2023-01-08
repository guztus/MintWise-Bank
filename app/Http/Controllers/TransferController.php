<?php

namespace App\Http\Controllers;

use App\Rules\CodecardCode;
use App\Services\TransferService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransferController extends Controller
{
    public function show(): View
    {
        Cache::forget('code');
        return view('transfer.show', [
            'currencies' => Cache::get('currencies'),
            'accounts' => Auth::user()->accounts,
            'code' => Cache::remember('code', 9999, function () {
                return fake()->numberBetween(1, 12);
            }),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $payerAccount = auth()->user()->accounts->where('number', $request->payerAccountNumber)->first();

        $request->validate([
            'code' =>
                [
                    'required',
                    'numeric',
                    new CodecardCode,
                ],
            'payerAccountNumber' =>
                [
                    'required',
                    'exists:accounts,number',
//                        check if this account belongs to the user
                ],
            'beneficiaryAccountNumber' =>
                [
                    'required',
                    'different:payerAccountNumber'
                ],
            'amount' =>
                [
                    'required',
                    'numeric',
                    'min:0.01',
                    'max:' . $payerAccount->balance / 100,
                ],
            'description' =>
                [
                    'required',
                    'string',
                ]
        ]);

        (new TransferService())->execute(
            $request->payerAccountNumber,
            $request->beneficiaryAccountNumber,
            $request->amount,
            $request->description
        );

        return redirect()->back();
    }
}
