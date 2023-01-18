<?php

namespace App\Http\Controllers;

use App\Actions\CryptoTransaction;
use App\Http\Interfaces\CryptoServiceInterface;
use App\Http\Requests\CryptoBuyRequest;
use App\Http\Requests\CryptoSellRequest;
use App\Models\Transaction;
use App\Repositories\CryptoRepository;
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
            'cryptoList' => $this->cryptoRepository->getList(),
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
            'assetOwned' => Auth::user()->assets->where('symbol', $symbol)->first() ?? null,
            'transactions' =>
                Transaction::where('currency_payer', $symbol)
                    ->orWhere('currency_beneficiary', $symbol)
                    ->get(),
        ]);
    }

    public function buy(
        CryptoBuyRequest $request
    ): RedirectResponse
    {
        (new CryptoTransaction())->execute(
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
        (new CryptoTransaction())->execute(
            $request->payerAccountNumber,
            $request->symbol,
            $request->assetAmount,
            Cache::get('latestPrice')
        );
        Cache::forget('latestPrice');

        return redirect()->back();
    }

    public function search(): RedirectResponse
    {
        return redirect()->route('crypto.show', ['symbol' => request('symbol')]);
    }
}
