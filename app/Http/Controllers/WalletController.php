<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\CryptoRepository;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WalletController extends Controller
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(): View
    {
        $accountNumber = Auth::user()->wallet->number;

        $transactions = Transaction::sortable(['created_at', 'desc'])
            ->where(function ($query) use ($accountNumber) {
                $query
                    ->where('beneficiary_account_number', $accountNumber)
                    ->orWhere('account_number', $accountNumber);
            });

        return view('wallet.index', [
            'assets' => (new PortfolioService($this->cryptoRepository))->execute(),
            'wallet' => Auth::user()->wallet,
            'accounts' => Auth::user()->accounts,
            'currencies' => Cache::get('currencies'),
            'transactions' => $transactions
                ->filter(request()->only('search', 'from', 'to'))
                ->paginate()
                ->withQueryString(),
            'credit' => $transactions->where('beneficiary_account_number', $accountNumber)->sum('amount_payer'),
            'debit' => $transactions->where('account_number', $accountNumber)->sum('amount_beneficiary'),
        ]);
    }

    public function deposit(): RedirectResponse
    {
//        validate
        $account = Auth::user()->accounts->find(request('account_id'));
        $amount = request('amount') * 100;

        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$account->currency];
        $walletRate = $currencies[config('global.currency_code')];
        $amountWithRate = $amount * $walletRate / $payerRate;

        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amount > $account->balance) {
            return redirect()->back()->with('message_danger', 'Transaction error. Not enough money in account ' . $account->number);
        }

        Auth::user()->wallet->deposit($amountWithRate);

        $account->balance -= $amount;
        $account->save();

        return redirect()->back()->with('message_success', "Transaction successful. Deposited " . number_format($amountWithRate / 100, 2) . " into wallet from {$account->number}");
    }

    public function withdraw(): RedirectResponse
    {
//        validate
        $account = Auth::user()->accounts->find(request('account_id'));
        $amount = request('amount') * 100;

        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$account->currency];
        $walletRate = $currencies[config('global.currency_code')];
        $amountWithRate = $amount * $walletRate / $payerRate;

        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amountWithRate > Auth::user()->wallet->balance) {
            return redirect()->back()->with('message_danger', "Not enough money in wallet!");
        }

        Auth::user()->wallet->withdraw($amountWithRate);

        $account->balance += $amount;
        $account->save();

        return redirect()->back()->with('message_success', 'Transaction successful. Withdrew ' .  number_format($amountWithRate / 100, 2) . " from wallet into {$account->number}");
    }
}
