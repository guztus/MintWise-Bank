<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Http\Requests\CryptoBuyRequest;
use App\Http\Requests\CryptoSaleRequest;
use App\Http\Requests\CryptoSellRequest;
use App\Repositories\CryptoRepository;
use App\Services\CryptoTransactionService;
use http\Env\Request;
use Illuminate\Http\RedirectResponse;
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
        CryptoBuyRequest $request
    ): RedirectResponse
    {
        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            Cache::get('latestPrice') * -1
        );
        Cache::forget('latestPrice');

        return redirect()->back();
    }

    public function sell(
        CryptoSellRequest $request
    ): RedirectResponse
    {
        (new CryptoTransactionService())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            Cache::get('latestPrice')
        );
        Cache::forget('latestPrice');

        return redirect()->back();
    }
}
