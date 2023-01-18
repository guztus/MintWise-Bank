<?php

namespace App\Http\Controllers;

use App\Actions\Transfer;
use App\Http\Requests\BalanceTransferRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TransferController extends Controller
{
    public function show(): View
    {
        Session::flash('codeNumber', fake()->numberBetween(1, 12));
        return view('transfer.show', [
            'currencies' => Cache::get('currencies'),
            'accounts' => Auth::user()->accounts,
            'codeNumber' => session()->get('codeNumber'),
        ]);
    }

    public function create(BalanceTransferRequest $request): RedirectResponse
    {
        (new Transfer())->execute(
            $request->payerAccountNumber,
            $request->beneficiaryAccountNumber,
            $request->amount,
            $request->description
        );
        return redirect()->back();
    }
}
