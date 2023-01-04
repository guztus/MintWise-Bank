<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function show(): View
    {
        return view('transfer.show', [
            'accounts' => Auth::user()->accounts,
            'code' => fake()->numberBetween(1 - 12),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'beneficiary_account_number' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
        ]);

        $amount = $request->amount * 100;

        $codeId = 'code_' . $request->codeId;

        $payerAccount = auth()->user()->accounts->where('number', $request->account_selected)->first();
        $payerAccount->balance -= $amount;

        if ($payerAccount->credit_limit < $payerAccount->balance
            && $request->beneficiary_account_number != $request->account_selected
            && $amount <= $payerAccount->balance + $amount
        ) {

            $beneficiaryAccount = Account::where('number', $request->beneficiary_account_number)->first();
            if (!empty($beneficiaryAccount)) {
                $beneficiaryAccount->balance += $amount;
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
                $payerAccount->save();
                $beneficiaryAccount->save();

                return redirect()->back()->with('message', 'Transfer successful!');
            }
        }
        return redirect()->back()->with('message', 'Transaction Error!');
    }
}
