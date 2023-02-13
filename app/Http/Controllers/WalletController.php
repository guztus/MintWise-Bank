<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\CryptoRepository;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
            'credit' => $transactions->where('account_number', $accountNumber)->sum('amount_payer'),
            'debit' => $transactions->where('beneficiary_account_number', $accountNumber)->sum('amount_beneficiary'),
        ]);
    }

    public function deposit(): RedirectResponse
    {
        $account = Auth::user()->accounts->find(request('account_id'));
        $amount = request('amount') * 100;

        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$account->currency];
        $walletRate = $currencies[config('global.currency_code')];
        $amountWithRate = $amount * $walletRate / $payerRate;

        $wallet = Auth::user()->wallet;

        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amount > $account->balance) {
            return redirect()->back()->with('message_danger', 'Transaction error. Not enough money in account ' . $account->number);
        }

        DB::transaction(
            function () use ($account, $wallet, $amount, $amountWithRate) {

                $wallet->deposit($amount);

                $account->balance -= $amountWithRate;
                $account->save();

                Transaction::create([
                    'account_number' => $account->number,
                    'beneficiary_account_number' => $wallet->number,
                    'description' =>
                        "Deposited "
                        . number_format($amount / 100, 2)
                        .  " " . config('global.currency_code')
                        . " (" . number_format($amountWithRate / 100, 2) . " {$account->currency})"
                        . " into wallet from {$account->number} ",
                    'type' => "Wallet deposit",
                    'amount_payer' => $amountWithRate / 100,
                    'currency_payer' => config('global.currency_code'),
                    'amount_beneficiary' => $amount / 100,
                    'currency_beneficiary' => $account->currency,
                ]);

                return redirect()->back()->with('message_success',
                    "Transaction successful. Deposited "
                    . number_format($amount / 100, 2)
                    .  " " . config('global.currency_code')
                    . " (" . number_format($amountWithRate / 100, 2) . " {$account->currency})"
                    . " into wallet from {$account->number} "
                );
            }
        );

        return redirect()->back()->with('message_danger', 'Transaction error');
    }

    public function withdraw(): RedirectResponse
    {
        $account = Auth::user()->accounts->find(request('account_id'));
        $wallet = Auth::user()->wallet;
        $amount = request('amount') * 100;

        $currencies = Cache::get('currencies');
        $payerRate = $currencies[$account->currency];
        $walletRate = $currencies[config('global.currency_code')];
        $amountWithRate = $amount * $walletRate / $payerRate;

        if (!$account) {
            return redirect()->back()->with('message_danger', 'Transaction error');
        }
        if ($amount > $wallet->balance) {
            return redirect()->back()->with('message_danger', "Not enough money in wallet!");
        }

        DB::transaction(
            function () use ($account, $wallet, $amount, $amountWithRate) {

            $wallet->withdraw($amount);

            $account->balance += $amountWithRate;
            $account->save();

            Transaction::create([
                'account_number' => $wallet->number,
                'beneficiary_account_number' => $account->number,
                'description' =>
                    "Withdrew "
                    . number_format($amount / 100, 2)
                    .  " " . config('global.currency_code')
                    . " (" . number_format($amountWithRate / 100, 2) . " {$account->currency})"
                    . " from wallet into {$account->number}",
                'type' => "Wallet withdraw",
                'amount_payer' => $amount / 100,
                'currency_payer' => $account->currency,
                'amount_beneficiary' => $amountWithRate / 100,
                'currency_beneficiary' => config('global.currency_code'),
            ]);

            return redirect()->back()->with('message_success',
                'Transaction successful. Withdrew '
                . number_format($amount / 100, 2)
                .  " " . config('global.currency_code')
                . " (" . number_format($amountWithRate / 100, 2) . " {$account->currency})"
                . " from wallet into {$account->number}");
            }
        );

        return redirect()->back()->with('message_danger', 'Transaction error');
    }
}
