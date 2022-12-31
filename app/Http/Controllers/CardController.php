<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CardController extends Controller
{
    public function show(): View
    {
        return view('cards', [
            'cards' => auth()->user()->cards,
        ]);
    }

//    public function showOne(Request $request): View
//    {
//
//    }

    public function create(Request $request)
    {
        auth()->user()->cards()->create([
            'cardholder_name' => $request->name,
            'type' => $request->type,
            'number' => fake()->creditCardNumber,
            'security_code' => fake()->numberBetween(100,999),
            'expiration_date' => now()->addYears(5),
            'design' => 1,
        ]);

        return redirect()->back()->with('message', 'Card order created!');
    }
}
