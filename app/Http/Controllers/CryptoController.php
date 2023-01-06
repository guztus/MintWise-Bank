<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CryptoController extends Controller
{
    public function __construct(CryptoServiceInterface $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function index(): View
    {
        return view('crypto.list', [
            'cryptoList' => $this->cryptoService->getList()->getCoins(),
        ]);
    }

    public function show(string $symbol): View
    {
        $symbol = strtoupper($symbol);
        return view('crypto.single', [
            'accounts' => Auth::user()->accounts,
            'crypto' => $this->cryptoService->getSingle($symbol),
        ]);
    }

    public function buy(Request $request, string $symbol)
    {
//        echo "<pre>";
//        var_dump($request->request);die;

        $assetAmount = $request->asset_amount;
        $fiatAmount = $request->amount;

        if (!Str::contains($assetAmount, '.')) {
            $assetAmount .= '.0';
        }
        [$amount_before_decimal, $amount_after_decimal] = explode('.', $assetAmount);
//        validation

//      Get latest price
//        $latestPrice = $this->cryptoService->getSingle($symbol)->quote->USD->price;
//        if ($assetAmount * $latestPrice > $fiatAmount) {
//            return redirect()->back()->with('error', 'You do not have enough money to buy this amount of crypto');
//        }

//        take cash
        $account = Auth::user()->accounts->where('number', $request->account)->first();
        $account->balance -= $fiatAmount * 100;
        $account->save();

//        add to users transactions
        $transaction = new Transaction();
        $transaction->account_number = $request->account;
        $transaction->beneficiary_account_number = 'Crypto';
        $transaction->description = 'Buy ' . $request->asset_amount . ' ' . $symbol;
        $transaction->type = 'Crypto BUY';
        $transaction->amount = $request->asset_amount;
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
                'amount_before_decimal' => DB::raw('amount_before_decimal + ' . (int)$amount_before_decimal),
                'amount_after_decimal' => DB::raw('amount_after_decimal + ' . (int)$amount_after_decimal),
                'type' => 'standard'
            ]);

        return redirect()->back()->with('message', 'You have successfully bought ' . $request->asset_amount . ' ' . $symbol);
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
