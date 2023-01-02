<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function show(): View
    {
        return view('transfer', [
            'accounts' => auth()->user()->accounts,
            'code' => fake()->numberBetween(1-12),
        ]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        $amount = $request->amount * 100;

        $codeId = 'code_'.$request->codeId;

        $payerAccount = auth()->user()->accounts->where('id', $request->account_selected)->first();
        $payerAccount->balance -= $amount;
        $payerAccount->save();

        $beneficiaryAccount = Account::where('number', $request->beneficiary_account_number)->first();
        if (!empty($beneficiaryAccount)) {
            $beneficiaryAccount->balance += $amount;
            $beneficiaryAccount->save();
        }

        if ($request->code == auth()->user()->codeCard->$codeId) {
            $transaction = new Transaction();
            $transaction->account_number = $payerAccount->number;
            $transaction->beneficiary_account_number = $request->beneficiary_account_number;
            $transaction->description = $request->description;
            $transaction->type = 'transfer';
            $transaction->amount = $amount;
            $transaction->currency = $request->currency_selected;
            $transaction->save();

            return redirect()->back()->with('message', 'Transfer successful!');
        }
        return redirect()->back()->with('message', 'Transaction Error!');
    }
}
