<?php

namespace App\Http\Controllers;

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
        return view('account', [
            'account' => auth()->user()->accounts->where('name', $request->name)->first() ?? abort(404),
            'transactions' => auth()->user()->transactions->where('account_id', auth()->user()->accounts->where('name', $request->name)->first()->id),
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
