<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.list', [
            'currencies' => Cache::get('currencies'),
            'accounts' => auth()->user()->accounts,
        ]);
    }

    public function showOne(Request $request): View
    {
        $account = auth()->user()->accounts->where('id', $request->id)->first();
        $accountNumber = $account->number;

        return view('account.single', [
            'account' => auth()->user()->accounts->where('number', $accountNumber)->first(),
            'transactions' =>
                Transaction::where('account_number', $accountNumber)
                ->orWhere('beneficiary_account_number', $accountNumber)
                ->get(),
            'cards' => Card::where('account_number', $accountNumber)->get(),
       ]);
    }

    public function create(Request $request)
    {
        Auth::user()->accounts()->create([
            'number' => fake()->iban('LV', 'HABA'),
            'label' => Str::ucfirst($request->label),
            'currency' => $request->currency
        ]);

        return redirect()->back()->with('message', 'Account successfully created!');
    }

    public function update(Request $request)
    {
        $account = auth()->user()->accounts->where('id', $request->id)->first();
        $account->label = Str::ucfirst($request->newLabel);
        $account->save();

        return redirect()->back()->with('message', 'Account successfully updated!');
    }

    public function destroy(Request $request)
    {
        $account = auth()->user()->accounts->where('id', $request->id)->first();
        $account->delete();

        return redirect()->to(route('accounts.index'))->with('message', 'Account successfully deleted!');
    }
}
