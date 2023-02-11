<?php

namespace App\Actions;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CryptoTransaction
{
    public function execute(
        string $symbol,
        float  $assetAmount,
        float  $latestPrice,
    ): void
    {
        $orderSum = round($assetAmount * $latestPrice, 2);
        $assetAmount = $orderSum / $latestPrice; // recalculated to avoid rounding errors

        DB::transaction(
            function () use ($symbol, $assetAmount, $orderSum, $latestPrice) {
                $wallet = Auth::user()->wallet;
                $wallet->balance += $orderSum * 100;
                $wallet->save();

                if ($orderSum > 0) {
                    $this->sell(Auth::user()->wallet, $symbol, $assetAmount, $orderSum);
                } else {
                    $this->buy(Auth::user()->wallet, $symbol, $assetAmount, $orderSum * -1, $latestPrice);
                }
            }
        );
    }

    private function sell(
        Wallet  $account,
        string  $symbol,
        float   $assetAmount,
        float   $orderSum,
    ): void
    {
//        add to assets (update or create)
        $this->updateAssets($symbol, $assetAmount * -1);
//        flash message
        $assetAmount = $this->formatAmount($assetAmount);
//        add to users transactions
        $this->addSellTransaction($account, $assetAmount, $symbol, $orderSum);

        $orderSum = abs($orderSum);
        Session::flash('message_success',
            "Transaction successful!
            Sold $assetAmount $symbol for "
            . number_format($orderSum, 2)
            . "from {$account->number}"
        );
    }

    private function buy(
        Wallet  $account,
        string  $symbol,
        float   $assetAmount,
        float   $orderSum,
        float   $latestPrice
    ): void
    {
//        calculate averageCost
        $asset = Auth::user()->wallet->assets()->where('symbol', $symbol)->first();
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
//        add to users transactions
        $this->addBuyTransaction($account, $assetAmount, $symbol, $orderSum);

        Session::flash('message_success',
            "Transaction successful!
            Bought $assetAmount $symbol for "
            . number_format($orderSum, 2)
            . " $account->currency from {$account->number}"
        );
    }

    private function updateAssets(
        string $symbol,
        string $assetAmount,
        ?float  $averageCost = null
    ): void
    {
        if ($averageCost) {
        Auth::user()->wallet->assets()->updateOrCreate(
            [
                'symbol' => $symbol
            ],
            [
                'wallet_id' => Auth::user()->wallet->id,
                'symbol' => $symbol,
                'average_cost' => $averageCost,
                'amount' => DB::raw("amount + $assetAmount"),
                'type' => 'standard'
            ]);
        } else {
            Auth::user()->wallet->assets()->updateOrCreate(
                [
                    'symbol' => $symbol
                ],
                [
                    'wallet_id' => Auth::user()->wallet->id,
                    'symbol' => $symbol,
                    'amount' => DB::raw("amount + $assetAmount"),
                    'type' => 'standard'
                ]);
        }
    }

    private function addBuyTransaction(
        Wallet  $account,
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
            'currency_payer' => 'EUR',
            'amount_beneficiary' => $assetAmount,
            'currency_beneficiary' => $symbol,
        ]);
    }

    private function addSellTransaction(
        Wallet  $account,
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
            'currency_beneficiary' => 'EUR',
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
