<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Http\Requests\CryptoSaleRequest;
use App\Repositories\CryptoRepository;
use App\Services\CryptoTransactionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    public function show(
        string $symbol
    ): View
    {
        $symbol = strtoupper($symbol);
        return view('crypto.single', [
            'accounts' => Auth::user()->accounts,
            'crypto' => $this->cryptoRepository->getSingle($symbol),
        ]);
    }

    public function buy(
        CryptoSaleRequest $request
    )
    {
        $request->validate([
            'symbol' => [
                'required',
            ],
        ]);

        $latestPrice = $this->cryptoService->getSingle($request->symbol)->getPrice();
        $this->validateAssetMinimumAmount($request, $latestPrice);

        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            $latestPrice * -1
        );

        return redirect()->back();
    }

    public function sell(
        CryptoSaleRequest $request
    )
    {
        $request->validate([
            'symbol' =>
                [
                    'in:' . Auth::user()->assets()->pluck('symbol')->implode('symbol', ','),
                ],
            'assetAmount' =>
                [
                    'max:' . Auth::user()->assets->where('symbol', $request->symbol)->first()->amount,
                ]
        ]);

        $latestPrice = $this->cryptoService->getSingle($request->symbol)->getPrice();
        $this->validateAssetMinimumAmount($request, $latestPrice);

        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            $latestPrice
        );

        return redirect()->back();
    }

    private function validateAssetMinimumAmount(
        CryptoSaleRequest $request,
        float             $latestPrice
    )
    {
        $minimumAmount = 0.01 / ($latestPrice * Cache::get('currencies')[auth()->user()->accounts->where('number', $request->payerAccountNumber)->first()->currency]);
        if (strpos($minimumAmount, "-")) {
            $minimumAmount = number_format($minimumAmount, (int)substr($minimumAmount, (strpos($minimumAmount, "-") + 1)));
        }

        $request->validate([
            'assetAmount' =>
                [
                    'min:' . $minimumAmount,
                ]
        ], [
                'assetAmount.min' => "Minimum amount is $minimumAmount $request->symbol",
            ]
        );
    }
}
