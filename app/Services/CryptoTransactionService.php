<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CryptoTransactionService
{
    public function execute(
        string $accountNumber,
        string $symbol,
        float  $assetAmount,
        float  $latestPrice,
    ): void
    {
//        take cash
        $account = Auth::user()->accounts->where('number', $accountNumber)->first();

        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$account->currency];

        $orderSum = round($assetAmount * $latestPrice * $payerRate, 2);
        $assetAmount = $orderSum / $payerRate / $latestPrice; // recalculated to avoid rounding errors

        DB::transaction(
            function () use ($account, $symbol, $assetAmount, $orderSum, $latestPrice) {
                $this->updatePayerAccount($account, $orderSum);

                if ($orderSum > 0) {
                    $this->sell($account, $symbol, $assetAmount, $orderSum);
                } else {
                    $this->buy($account, $symbol, $assetAmount, $orderSum, $latestPrice);
                }
            }
        );
    }

    private function buy(
        Account $account,
        string  $symbol,
        float   $assetAmount,
        float   $orderSum,
        float   $latestPrice
    ): void
    {
//        add to users transactions
        $this->addTransaction($account, $assetAmount, $symbol, 'Buy');

//        calculate averageCost
        $asset = Auth::user()->assets()->where('symbol', $symbol)->first();
        if ($asset) {
            $latestPrice = $latestPrice * -1;
            $averageCost = (int)number_format((($asset->average_cost * $asset->amount) + ($assetAmount * $latestPrice)) / ($asset->amount + $assetAmount) * 100, 2, '', '');
        } else {
            $averageCost = $latestPrice * -1;
        }

//        add to assets (update or create)
        $this->updateAssets($symbol, $assetAmount, $averageCost);

//        flash message
        $assetAmount = $this->formatAmount($assetAmount);
        session()->flash('message',
            "Transaction successful!
            Bought $assetAmount $symbol for "
            . $orderSum * -1
            . " $account->currency from {$account->number}"
        );
    }

    private function sell(
        Account $account,
        string  $symbol,
        float   $assetAmount,
        float   $orderSum,
    ): void
    {
//        add to users transactions
        $this->addTransaction($account, $assetAmount, $symbol, 'Sell');

//        add to assets (update or create)
        $this->updateAssets($symbol, $assetAmount * -1);

//        flash message
        $assetAmount = $this->formatAmount($assetAmount);
        $orderSum = abs($orderSum);
        session()->flash('message',
            "Transaction successful!
            Sold $assetAmount $symbol for $orderSum $account->currency from {$account->number}"
        );
    }

    private function updatePayerAccount(
        Account $payerAccount,
        float   $amount
    ): void
    {
        $payerAccount->balance += $amount * 100;
        $payerAccount->save();
    }

    private function updateAssets(
        string $symbol,
        string $assetAmount,
        float  $averageCost = 0
    ): void
    {
        Auth::user()->assets()->updateOrCreate(
            [
                'symbol' => $symbol,
            ],
            [
                'symbol' => $symbol,
                'average_cost' => $averageCost,
                'amount' => DB::raw("amount + $assetAmount"),
                'type' => 'standard'
            ]);
    }

    private function addTransaction(
        Account $account,
        string  $assetAmount,
        string  $symbol,
        string  $type
    ): void
    {
        Transaction::create([
            'account_number' => $account->number,
            'beneficiary_account_number' => 'Crypto',
            'description' => "$type $assetAmount $symbol",
            'type' => "Crypto $type",
            'amount_one' => $assetAmount,
            'currency_one' => $symbol,
            'amount_two' => null,
            'currency_two' => null,
        ]);
    }

    private function formatAmount(
        float $amount
    ): string
    {
        if (strpos($amount, "-")) {
            return number_format($amount, (int)substr($amount, (strpos($amount, "-") + 1)));
        }
        return $amount;
    }
}
