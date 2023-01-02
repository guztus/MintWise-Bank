<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function show(): View
    {
        return view('accounts', [
            'accounts' => auth()->user()->accounts,
        ]);
    }

    public function showOne(Request $request): View
    {
        $account = auth()->user()->accounts->where('name', $request->name)->first();
        $accountNumber = $account->number;

        return view('account', [
            'account' => auth()->user()->accounts->where('number', $accountNumber)->first(),
            'transactions' =>
                Transaction::where('account_number', $accountNumber)
                ->orWhere('beneficiary_account_number', $accountNumber)
                ->get(),
            'cards' => Card::whereIn('account_number', $account)->get(),
       ]);
    }

    public function create(Request $request)
    {
        auth()->user()->accounts()->create([
            'number' => fake()->iban('LV', 'HABA'),
            'name' => Str::ucfirst($request->name),
            'currency' => $request->currency
        ]);

        return redirect()->back()->with('message', 'Account successfully created!');
    }
}
