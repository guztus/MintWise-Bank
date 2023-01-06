<?php

namespace App\Http\Services;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransferService
{
    public function execute(int $code, $payer_account_number, $beneficiary_account_number, $amount, $description): bool
    {
        if (!$this->validateCode($code)) {
            return false;
        };

        $payerAccount = auth()->user()->accounts->where('number', $payer_account_number)->first();
        $amount = round($amount * 100);

        if ($payerAccount->credit_limit < $payerAccount->balance
            && $beneficiary_account_number != $payer_account_number
            && $amount <= $payerAccount->balance + $amount
        ) {
            $beneficiaryAccount = Account::where('number', $beneficiary_account_number)->first();
            if (!empty($beneficiaryAccount)) {
                $this->updateBeneficiaryAccount($beneficiaryAccount, $payerAccount, $amount);
            }
            $this->updatePayerAccount($payerAccount, $amount);
            $this->createTransaction($payerAccount, $beneficiary_account_number, $amount, $description);
            return true;
        }
        return false;
    }

    private function validateCode(int $code): bool
    {
        $codeId = 'code_' . Cache::get('code');

        if ($code != Auth::user()->codeCard->$codeId) {
            return false;
//            return redirect()->back()->with('error', 'Transfer Error - entered code was incorrect');
        }
        return true;
    }

    private function createTransaction(Account $payerAccount, string $beneficiary_account_number, float $amount, string $description): void
    {
        $transaction = new Transaction();
        $transaction->account_number = $payerAccount->number;
        $transaction->beneficiary_account_number = $beneficiary_account_number;
        $transaction->description = $description;
        $transaction->type = 'transfer';
        $transaction->amount = $amount;
        $transaction->currency = $payerAccount->currency;

        $transaction->save();
    }

    private function updatePayerAccount(Account $payerAccount, float $amount): void
    {
        $payerAccount->balance -= $amount;
        $payerAccount->save();
    }

    private function updateBeneficiaryAccount(Account $payerAccount, Account $beneficiaryAccount, int $amount): void
    {
        $amount = $amount / 100;
        $payerCurrency = $payerAccount->currency;
        $beneficiaryCurrency = $beneficiaryAccount->currency;

        $currencies = Cache::get('currencies');
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
//                    session(['message' => "Transfer currency exchanged from EUR to {$beneficiaryCurrency}. Paid: {$amount} {$beneficiaryCurrency}"]);
        } else if ($payerCurrency !== $beneficiaryCurrency && $beneficiaryCurrency == 'EUR') {

            $amount = $amount / $payerRate;
//                    session(['message' => "Transfer currency exchanged from {$payerCurrency} to EUR. Paid: {$amount} {$beneficiaryCurrency}"]);

        } else if ($payerCurrency !== $beneficiaryCurrency) {
            $amount = $amount * $beneficiaryRate / $payerRate;
//                    session(['message' => "Transfer currency exchanged from {$payerCurrency} to {$beneficiaryCurrency}. Paid: {$amount} {$beneficiaryCurrency}"]);
        }
        $beneficiaryAccount->balance += $amount * 100;
        $beneficiaryAccount->save();
    }

}
