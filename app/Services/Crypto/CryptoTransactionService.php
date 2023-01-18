<?php

namespace App\Services\Crypto;

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
                    $this->buy($account, $symbol, $assetAmount, $orderSum * -1, $latestPrice);
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
        $this->addBuyTransaction($account, $assetAmount, $symbol, $orderSum);

//        calculate averageCost
        $asset = Auth::user()->assets()->where('symbol', $symbol)->first();
        if ($asset) {
            $latestPrice = $latestPrice * -1;
            $averageCost = (float)number_format((($asset->average_cost * $asset->amount) + ($assetAmount * $latestPrice)) / ($asset->amount + $assetAmount), 2, '.', '');
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
            . number_format($orderSum, 2)
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
        $this->addSellTransaction($account, $assetAmount, $symbol, $orderSum);

//        add to assets (update or create)
        $this->updateAssets($symbol, $assetAmount * -1);

//        flash message
        $assetAmount = $this->formatAmount($assetAmount);
        $orderSum = abs($orderSum);
        session()->flash('message',
            "Transaction successful!
            Sold $assetAmount $symbol for "
            . number_format($orderSum, 2)
            . " $account->currency from {$account->number}"
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

    private function addBuyTransaction(
        Account $account,
        string  $assetAmount,
        string  $symbol,
        string  $orderSum
    ): void
    {
        Transaction::create([
            'account_number' => $account->number,
            'beneficiary_account_number' => 'Crypto',
            'description' => "Buy $assetAmount $symbol",
            'type' => "Crypto Buy",
            'amount_payer' => $orderSum,
            'currency_payer' => $account->currency,
            'amount_beneficiary' => $assetAmount,
            'currency_beneficiary' => $symbol,
        ]);
    }

    private function addSellTransaction(
        Account $account,
        string  $assetAmount,
        string  $symbol,
        string  $orderSum
    ): void
    {
        Transaction::create([
            'account_number' => 'Crypto',
            'beneficiary_account_number' => $account->number,
            'description' => "Sell $assetAmount $symbol",
            'type' => "Crypto Sell",
            'amount_payer' => $assetAmount,
            'currency_payer' => $symbol,
            'amount_beneficiary' => $orderSum,
            'currency_beneficiary' => $account->currency,
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
