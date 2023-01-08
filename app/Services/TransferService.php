<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class TransferService
{
    public function execute(
        string $payerAccountNumber,
        string $beneficiaryAccountNumber,
        float  $amount,
        string $description
    ): void
    {
        $amount *= 100;
        $payerAccount = auth()->user()->accounts->where('number', $payerAccountNumber)->first();
        $beneficiaryAccount = Account::where('number', $beneficiaryAccountNumber)->first();

        $this->updatePayerAccount($payerAccount, $amount);
        $this->createTransaction($payerAccount, $beneficiaryAccount, $amount, $description);

        if (!empty($beneficiaryAccount)) {
            $this->updateBeneficiaryAccount($payerAccount, $beneficiaryAccount, $amount);
        } else {
            session()->flash('message', "Transfer successful! Sent $amount EUR from {$payerAccountNumber} to {$beneficiaryAccountNumber}.");
        }
    }

    private function createTransaction(
        Account $payerAccount,
        Account $beneficiaryAccount,
        float   $amount,
        string  $description
    ): void
    {
        $transaction = new Transaction();
        $transaction->account_number = $payerAccount->number;
        $transaction->beneficiary_account_number = $beneficiaryAccount->number;
        $transaction->description = $description;
        $transaction->type = 'transfer';
        $transaction->amount = $amount;
        $transaction->currency = $payerAccount->currency;
        $transaction->save();
    }

    private function updatePayerAccount(
        Account $payerAccount,
        float   $amount
    ): void
    {
        $payerAccount->balance -= $amount;
        $payerAccount->save();
    }

    private function updateBeneficiaryAccount(
        Account $payerAccount,
        Account $beneficiaryAccount,
        int     $amount
    ): void
    {
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

        if ($payerCurrency !== $beneficiaryCurrency) {
            $amountWithRate = $amount * $beneficiaryRate / $payerRate;
            session()->flash('message', "Transfer successful!
                Sent $amount EUR from {$payerAccount->number} to {$beneficiaryAccount->number}.
                \n Currency exchanged from {$payerCurrency} to {$beneficiaryCurrency}. Paid: {$amountWithRate} {$beneficiaryCurrency}");
        } else {
            session()->flash('message', "Transfer successful!
                Sent $amount EUR from {$payerAccount->number} to {$beneficiaryAccount->number}.");
        }

        $beneficiaryAccount->balance += $amount * 100;
        $beneficiaryAccount->save();
    }

}
