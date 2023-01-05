<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransferController extends Controller
{
    public function show(): View
    {
        return view('transfer.show', [
            'currencies' => Cache::get('currencies'),
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

        $amount = $request->amount;

        $currencies = Cache::get('currencies');

        $amount = round($amount * 100);

        $codeId = 'code_' . $request->codeId;

        $payerAccount = auth()->user()->accounts->where('number', $request->account_selected)->first();
        $payerAccount->balance -= $amount;

        if ($payerAccount->credit_limit < $payerAccount->balance
            && $request->beneficiary_account_number != $request->account_selected
            && $amount <= $payerAccount->balance + $amount
        ) {
            $beneficiaryAccount = Account::where('number', $request->beneficiary_account_number)->first();
            if (!empty($beneficiaryAccount)) {
                $amount = $amount / 100;
                $payerCurrency = $payerAccount->currency;
                $beneficiaryCurrency = $beneficiaryAccount->currency;

                foreach ($currencies as $currency) {
                    if ($currency['id'] == $payerCurrency) {
                        $payerRate = $currency['rate'];
                    }
                    if ($currency['id'] == $beneficiaryCurrency) {
                        $beneficiaryRate = $currency['rate'];
                    }
                }

                if ($payerCurrency !== $beneficiaryCurrency && $payerCurrency == 'EUR') {
                    $amount = $amount * $beneficiaryRate;
//                    return redirect()->back()->with('message', "Transfer currency exchanged from EUR to {$beneficiaryCurrency}. Paid: {$amount} {$beneficiaryCurrency}");

                } else if ($payerCurrency !== $beneficiaryCurrency && $beneficiaryCurrency == 'EUR') {
                    $amount = $amount / $payerRate;
//                    return redirect()->back()->with('message', "Transfer currency exchanged from {$payerCurrency} to EUR. Paid: {$amount} {$beneficiaryCurrency}");

                } else if ($payerCurrency !== $beneficiaryCurrency) {
                    $amount = $amount * $beneficiaryRate / $payerRate;
//                    return redirect()->back()->with('message', "Transfer currency exchanged from {$payerCurrency} to {$beneficiaryCurrency}. Paid: {$amount} {$beneficiaryCurrency}");
                }
                $beneficiaryAccount->balance += $amount * 100;
            }

//            if ($request->code == auth()->user()->codeCard->$codeId) {
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
//            }
        }
        return redirect()->back()->with('message', 'Transaction Error!');
    }
}
