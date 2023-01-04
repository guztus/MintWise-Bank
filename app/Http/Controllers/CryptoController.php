<?php

namespace App\Http\Controllers;

use App\Http\Services\CryptoCoinMarketCapAPIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CryptoController extends Controller
{
    public function index(): View
    {
        return view('crypto.list', [
            'cryptoList' => (new CryptoCoinMarketCapAPIService)->getList(),
        ]);
    }

    public function show(string $symbol): View
    {
        $symbol = strtoupper($symbol);
        return view('crypto.single', [
            'accounts' => Auth::user()->accounts,
            'crypto' => (new CryptoCoinMarketCapAPIService)->getSingle($symbol)->data->$symbol[0],
        ]);
    }

    public function buy(string $symbol)
    {
        $assetAmount = request('asset_amount');
        if (!Str::contains($assetAmount, '.')) {
            $assetAmount .= '.0';
        }
        [$amount_before_decimal, $amount_after_decimal] = explode('.', $assetAmount);

//        add to users transactions

        Auth::user()->assets()->updateOrCreate(
            [
                'symbol' => $symbol,
            ],
            [
                'symbol' => $symbol,
                'average_cost_before_decimal' => 0,
                'average_cost_after_decimal' => 0,
                'amount_before_decimal' => DB::raw('amount_before_decimal + ' . (int)$amount_before_decimal),
                'amount_after_decimal' => DB::raw('amount_after_decimal + ' . (int)$amount_after_decimal),
                'type' => 'standard'
            ]);

        return redirect()->back();
    }

    public function sell(string $symbol)
    {
        $assetAmount = request('asset_amount');
        if (!Str::contains($assetAmount, '.')) {
            $assetAmount .= '.0';
        }
        [$amount_before_decimal, $amount_after_decimal] = explode('.', $assetAmount);

        Auth::user()->assets()->updateOrCreate(
            [
                'symbol' => $symbol,
            ],
            [
                'symbol' => $symbol,
                'average_cost_before_decimal' => 0,
                'average_cost_after_decimal' => 0,
                'amount_before_decimal' => DB::raw('amount_before_decimal - ' . (int)$amount_before_decimal),
                'amount_after_decimal' => DB::raw('amount_before_decimal - ' . (int)$amount_after_decimal),
                'type' => 'standard'
            ]);

        return redirect()->back();
    }
}
