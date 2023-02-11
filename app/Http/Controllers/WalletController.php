<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CryptoRepository;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(): View
    {
        return view('wallet.index', [
            'assets' => (new PortfolioService($this->cryptoRepository))->execute(),
            'wallet' => Auth::user()->wallet,
            'accounts' => Auth::user()->accounts,
        ]);
    }

    public function deposit(): RedirectResponse
    {
//        handle currency conversion

        $amount = request('amount') * 100;
        $account = Auth::user()->accounts->find(request('account_id'));
        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amount > $account->balance) {
            return redirect()->back()->with('message_danger', 'Transaction error. Not enough money in account ' . $account->number);
        }

        Auth::user()->wallet->deposit($amount);
        $account->balance -= $amount;
        $account->save();

        return redirect()->back()->with('message_success', "Transaction successful. Deposited " . number_format($amount / 100, 2) . " into wallet from {$account->number}");
    }

    public function withdraw(): RedirectResponse
    {
//        handle currency conversion

        $amount = request('amount') * 100;

        $account = Auth::user()->accounts->find(request('account_id'));
        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amount > Auth::user()->wallet->balance) {
            return redirect()->back()->with('message_danger', "Not enough money in wallet!");
        }

        Auth::user()->wallet->withdraw($amount);
        $account->balance += $amount;
        $account->save();

        return redirect()->back()->with('message_success', 'Transaction successful. Withdrew ' .  number_format($amount / 100, 2) . " from wallet into {$account->number}");
    }
}
