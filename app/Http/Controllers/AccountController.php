<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.list', [
            'currencies' => Cache::get('currencies'),
            'accounts' => Auth::user()->accounts,
        ]);
    }

    public function showOne(): View
    {
        $accountNumber = Auth::user()->accounts->where('id', request('id'))->first()->number;

        return view('account.single', [
            'account' => Auth::user()->accounts->where('number', $accountNumber)->first(),
            'transactions' =>
                Transaction::sortable()->where('account_number', $accountNumber)
                    ->orWhere('beneficiary_account_number', $accountNumber)
                    ->filter(request(['search', 'order']))
                    ->paginate(5)->withQueryString(),
            'cards' => Card::where('account_number', $accountNumber)->get(),
        ]);
    }

    public function create()
    {
        Auth::user()->accounts()->create([
            'number' => fake()->iban('LV', 'HABA'),
            'label' => Str::ucfirst(request('label')),
            'currency' => request('currency')
        ]);

        return redirect()->back()->with('message', 'Account successfully created!');
    }

    public function update()
    {
        $account = Auth::user()->accounts->where('id', request('id'))->first();
        $account->label = Str::ucfirst(request('newLabel'));
        $account->save();

        return redirect()->back()->with('message', 'Account successfully updated!');
    }

    public function destroy()
    {
        $account = Auth::user()->accounts->where('id', request('id'))->first();
        $account->delete();

        return redirect()->to(route('accounts.index'))->with('message', 'Account successfully deleted!');
    }

    protected function getTransactions()
    {
        return Transaction::latest()->filter()->get();
    }
}
