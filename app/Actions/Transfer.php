<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Transfer
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

        DB::transaction(function () use ($payerAccount, $beneficiaryAccountNumber, $amount, $description) {
            $this->updatePayerAccount($payerAccount, $amount);
            $this->createTransaction($payerAccount, $beneficiaryAccountNumber, $amount / 100, $description);

            $beneficiaryAccount = Account::where('number', $beneficiaryAccountNumber)->first();
            if (!empty($beneficiaryAccount)) {
                $this->updateBeneficiaryAccount($payerAccount, $beneficiaryAccount, $amount);
            } else {
                session()->flash('message_success', "Transfer successful! Sent "
                    . $amount / 100
                    . " {$payerAccount->currency} from {$payerAccount->number} to {$beneficiaryAccountNumber}."
                );
            }
        });
    }

    private function createTransaction(
        Account $payerAccount,
        string  $beneficiaryAccountNumber,
        float   $amount,
        string  $description
    ): void
    {
        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$payerAccount->currency];

        $beneficiaryAccount = Account::where('number', $beneficiaryAccountNumber)->first();
        if ($beneficiaryAccount) {
            $beneficiaryRate = $currencies[$beneficiaryAccount->currency];
            $amountWithRate = $amount * $beneficiaryRate / $payerRate;
        }

        Transaction::create([
            'account_number' => $payerAccount->number,
            'beneficiary_account_number' => $beneficiaryAccountNumber,
            'description' => $description,
            'type' => 'transfer',
            'amount_payer' => $amount,
            'currency_payer' => $payerAccount->currency,
            'amount_beneficiary' => $amountWithRate ?? null,
            'currency_beneficiary' => $beneficiaryAccount->currency ?? null,
        ]);
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
        $payerRate = $currencies[$payerCurrency];
        $beneficiaryRate = $currencies[$beneficiaryCurrency];

        $amountWithRate = $amount * $beneficiaryRate / $payerRate;
        if ($payerCurrency !== $beneficiaryCurrency) {
            session()->flash('message_success', "Transfer successful!
                Sent " . $amount / 100 . " {$payerCurrency} from {$payerAccount->number} to {$beneficiaryAccount->number}.
                \n Currency exchanged from {$payerCurrency} to {$beneficiaryCurrency}. Sent: "
                . number_format($amountWithRate / 100, 2)
                . " {$beneficiaryCurrency}");
        } else {
            session()->flash('message_success', "Transfer successful!
                Sent " . $amount / 100 . " {$payerAccount->currency} from {$payerAccount->number} to {$beneficiaryAccount->number}.");
        }

        $beneficiaryAccount->balance += (float)number_format($amountWithRate, 2);
        $beneficiaryAccount->save();
    }
}
