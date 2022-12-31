<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function show(): View
    {
        return view('transfer', [
            'accounts' => auth()->user()->accounts,
            'code' => fake()->numberBetween(1-12),
        ]);
    }

    public function confirm(Request $request): \Illuminate\Http\RedirectResponse
    {
        \Log::info($request);
        //
//        find code in code card - code comes from request

        $codeId = 'code_'.$request->codeId;
//        \Log::info(auth()->user()->codeCard->$codeId);

        if ($request->code == auth()->user()->codeCard->$codeId) {
            auth()->user()->transactions()->create(
                [
                    'account_id' => $request->account_selected,
                    'account_number' => 398790902469, // should be name
                    'recipient_user_id' => rand(1, 1351315), // should be account
//                    'recipient_account_number' => $request->recipient_account_number, // should be account
                    'recipient_account_number' => fake()->iban('LV', 'HABA'), // should be account
                    'description' => $request->description,
                    'type' => 'outgoing_transfer',
                    'amount' => $request->amount * 100 * -1,
                    'currency' => $request->currency_selected,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );


            return redirect()->back()->with('message', 'Code confirmed!');
        }
        return redirect()->back()->with('message', 'Transaction Error!');
//        \Log::info(auth()->user()->codeCard->$codeId);
    }
}
