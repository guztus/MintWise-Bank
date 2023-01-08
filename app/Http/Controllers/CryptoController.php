<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Repositories\CryptoRepository;
use App\Services\CryptoTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoController extends Controller
{
    public function __construct(CryptoServiceInterface $cryptoService, CryptoRepository $cryptoRepository)
    {
        $this->cryptoService = $cryptoService;
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(): View
    {
        return view('crypto.list', [
            'cryptoList' => $this->cryptoRepository->getList()->getCoins(),
        ]);
    }

    public function show(string $symbol): View
    {
        $symbol = strtoupper($symbol);
        return view('crypto.single', [
            'accounts' => Auth::user()->accounts,
            'crypto' => $this->cryptoRepository->getSingle($symbol),
        ]);
    }

    public function buy(Request $request, string $symbol)
    {
        $latestPrice = $this->cryptoService->getSingle($symbol)->getPrice();
        $payerAccount = auth()->user()->accounts->where('number', $request->payerAccountNumber)->first();

        $request->validate([
//            ideally check if symbol exists in the list
                'payerAccountNumber' =>
                    [
                        'required',
                        'exists:accounts,number',
//                        check if this account belongs to the user
                    ],
                'assetAmount' =>
                    [
                        'required',
                        'numeric',
                        'min:' . $latestPrice * 0.01,
                        'max:' . $payerAccount->balance / 100 / $latestPrice,
                    ],
            ]
        );
        $orderSum = $request->assetAmount * $latestPrice;

        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            $orderSum
        );

        return redirect()->back();
    }

    public function sell(Request $request, string $symbol)
    {
        $latestPrice = $this->cryptoService->getSingle($symbol)->getPrice();

        $ownedAsset = Auth::user()->assets->where('symbol', 777)->first();

        $request->validate([
                'payerAccountNumber' =>
                    [
                        'required',
                        'exists:accounts,number',
//                        check if this account belongs to the user
                    ],
//            ideally check if symbol exists in the list
                'assetAmount' =>
                    [
                        'required',
                        'numeric',
                        'min:' . $latestPrice * 0.01,
                        'max:' . $ownedAsset->amount_before_decimal . "." . $ownedAsset->amount_after_decimal,
                    ],
            ]
        );

        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            $latestPrice
        );

        return redirect()->back();
    }
}
