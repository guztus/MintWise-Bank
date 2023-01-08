<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CryptoTransactionService
{
    public function execute(
        string $payerAccountNumber,
        string $symbol,
        string $assetAmount,
        float  $latestPrice,
    ): void
    {
//        take cash
        $account = Auth::user()->accounts->where('number', $payerAccountNumber)->first();

        $currencies = Cache::get('currencies');
        foreach ($currencies as $currency) {
            if ($currency['id'] == $account->currency) {
                $payerRate = $currency['rate'];
            }
        }
        $orderSum = $assetAmount * $latestPrice * $payerRate;
        $account->balance -= $orderSum * 100;
        $account->save();

        if ($orderSum > 0) {
            $this->buy($payerAccountNumber, $symbol, $assetAmount, $orderSum);
        } else {
            $this->sell($payerAccountNumber, $symbol, $assetAmount, $orderSum);
        }
    }

    public function buy(
        string $payerAccountNumber,
        string $symbol,
        string $assetAmount,
        float  $orderSum,
    )
    {
        if (!Str::contains($assetAmount, '.')) {
            $assetAmount .= '.0';
        }
        [$amountBeforeDecimal, $amountAfterDecimal] = explode('.', $assetAmount);

//        add to users transactions
        $transaction = new Transaction();
        $transaction->account_number = $payerAccountNumber;
        $transaction->beneficiary_account_number = 'Crypto';
        $transaction->description = 'Buy ' . $assetAmount . ' ' . $symbol;
        $transaction->type = 'Crypto BUY';
        $transaction->amount = $assetAmount;
        $transaction->currency = $symbol;
        $transaction->save();

//        add to assets (update or create)
        Auth::user()->assets()->updateOrCreate(
            [
                'symbol' => $symbol,
            ],
            [
                'symbol' => $symbol,
                'average_cost_before_decimal' => 0,
                'average_cost_after_decimal' => 0,
                'amount_before_decimal' => DB::raw('amount_before_decimal + ' . (int)$amountBeforeDecimal),
                'amount_after_decimal' => DB::raw('amount_after_decimal + ' . (int)$amountAfterDecimal),
                'type' => 'standard'
            ]);

        session()->flash('message', "Crypto transaction successful! Bought $assetAmount $symbol for $orderSum EUR from {$payerAccountNumber}.");
    }

    public function sell(
        string $payerAccountNumber,
        string $symbol,
        string $assetAmount,
        float  $orderSum,
    ): void
    {
        if (!Str::contains($assetAmount, '.')) {
            $assetAmount .= '.0';
        }
        [$amountBeforeDecimal, $amountAfterDecimal] = explode('.', $assetAmount);

//        add to users transactions
        $transaction = new Transaction();
        $transaction->account_number = $payerAccountNumber;
        $transaction->beneficiary_account_number = 'Crypto';
        $transaction->description = 'Sell ' . $assetAmount . ' ' . $symbol;
        $transaction->type = 'Crypto SELL';
        $transaction->amount = $assetAmount;
        $transaction->currency = $symbol;
        $transaction->save();

//        add to assets (update or create)
        Auth::user()->assets()->updateOrCreate(
            [
                'symbol' => $symbol,
            ],
            [
                'symbol' => $symbol,
                'average_cost_before_decimal' => 0,
                'average_cost_after_decimal' => 0,
                'amount_before_decimal' => DB::raw('amount_before_decimal - ' . (int)$amountBeforeDecimal),
                'amount_after_decimal' => DB::raw('amount_after_decimal - ' . (int)$amountAfterDecimal),
                'type' => 'standard'
            ]);

        $orderSum = abs($orderSum);
        session()->flash('message', "Crypto transaction successful! Sold $assetAmount $symbol for $orderSum EUR from {$payerAccountNumber}.");
    }
}
