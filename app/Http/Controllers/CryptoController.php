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
use Illuminate\Support\Facades\Session;
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
        $accountNumber = Auth::user()->wallet->number;

        $transactions = Transaction::sortable(['created_at', 'desc'])
            ->where(function ($query) use ($symbol) {
                $query
                    ->where('currency_payer', $symbol)
                    ->orWhere('currency_beneficiary', $symbol);
            })
            ->where(function ($query) use ($accountNumber) {
                $query
                    ->where('beneficiary_account_number', $accountNumber)
                    ->orWhere('account_number', $accountNumber);
            });

        $symbol = strtoupper($symbol);
        return view('crypto.single', [
            'wallet' => Auth::user()->wallet,
            'crypto' => $this->cryptoRepository->getSingle($symbol),
            'assetOwned' => Auth::user()->wallet->assets->where('symbol', $symbol)->first() ?? null,
            'transactions' => $transactions
                ->filter(request()->only('search', 'from', 'to'))
                ->paginate()
                ->withQueryString(),
            'credit' => $transactions->where('currency_beneficiary', $symbol)->sum('amount_payer'),
            'debit' => $transactions->where('currency_payer', $symbol)->sum('amount_beneficiary'),
        ]);
    }

    public function buy(
        CryptoBuyRequest $request
    ): RedirectResponse
    {
        (new CryptoTransaction())->execute(
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
