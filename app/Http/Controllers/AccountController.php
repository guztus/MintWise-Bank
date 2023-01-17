<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
            'accounts' => Auth::user()->accounts,
        ]);
    }

    public function showOne(): View
    {
        $accountNumber = Auth::user()->accounts->where('id', request('id'))->first()->number;
        return view('account.single', [
            'account' => Auth::user()->accounts->where('number', $accountNumber)->first(),
            'transactions' =>
                Transaction::sortable(['created_at', 'desc'])->where('account_number', $accountNumber)
                    ->orWhere('beneficiary_account_number', $accountNumber)
                    ->filter(request()->only('search', 'from', 'to'))
                    ->paginate()
                    ->withQueryString(),
            'cards' => Card::where('account_number', $accountNumber)->get(),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);
        Auth::user()->accounts()->create([
            'number' => fake()->iban('LV', 'HABA'),
            'label' => Str::ucfirst(request('label')),
            'currency' => request('currency')
        ]);

        return redirect()->back()->with('message_success', 'Account successfully created!');
    }

    public function update(): RedirectResponse
    {
        $account = Auth::user()->accounts->where('id', request('id'))->first();
        $account->label = Str::ucfirst(request('newLabel'));
        $account->save();

        return redirect()->back()->with('message_success', 'Account successfully updated!');
    }

    public function destroy(): RedirectResponse
    {
        $account = Auth::user()->accounts->where('id', request('id'))->first();
        if ($account->balance != 0) {
            return redirect()->back()->with('message_danger', 'Account balance must be 0 to delete it!');
        }
        $account->delete();

        return redirect()->to(route('accounts.index'))->with('message_success', 'Account successfully deleted!');
    }
}
