<?php

namespace App\Http\Controllers;

use App\Http\Services\TransferService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransferController extends Controller
{
    public function show(): View
    {
        Cache::forget('code');
        return view('transfer.show', [
            'currencies' => Cache::get('currencies'),
            'accounts' => Auth::user()->accounts,
            'code' => Cache::remember('code', 9999, function () {
                return fake()->numberBetween(1, 12);
            }),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|numeric',
            'payer_account_number' => 'required',
            'beneficiary_account_number' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string'
        ]);

//        need to implement exception using try catch
        $transferTry = (new TransferService())->execute(
            $request->code,
            $request->payer_account_number,
            $request->beneficiary_account_number,
            $request->amount,
            $request->description
        );

        if ($transferTry) {
            return redirect()->back()->with('message', 'Transaction Successful!');
        }
        return redirect()->back()->with('message', 'Transaction Error!');
    }
}
