<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CardController extends Controller
{
    public function show(): View
    {
        return view('card.list', [
            'accounts' => auth()->user()->accounts,
            'cards' => Card::whereIn('account_number', auth()->user()->accounts->pluck('number'))->get(),
        ]);
    }

    public function create(Request $request)
    {
        Card::create([
            'account_id' => $request->account_id,
            'account_number' => auth()->user()->accounts->where('id', $request->account_id)->first()->number,
            'cardholder_name' => auth()->user()->name,
            'type' => $request->type,
            'number' => fake()->creditCardNumber,
            'security_code' => fake()->numberBetween(100,999),
            'expiration_date' => now()->addYears(5),
            'design' => 1,
        ]);

        return redirect()->back()->with('message', 'Card order created!');
    }
}
