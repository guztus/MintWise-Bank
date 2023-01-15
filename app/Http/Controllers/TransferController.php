<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceTransferRequest;
use App\Services\TransferService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function create(BalanceTransferRequest $request): RedirectResponse
    {
        (new TransferService())->execute(
            $request->payerAccountNumber,
            $request->beneficiaryAccountNumber,
            $request->amount,
            $request->description
        );
        return redirect()->back();
    }
}
