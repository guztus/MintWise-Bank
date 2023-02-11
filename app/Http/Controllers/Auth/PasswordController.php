<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if (!$validated) {
            Session::flash('message_danger', 'Password changed successfully!');
            return back();
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        Session::flash('message_success', 'Password changed successfully!');

        return back()->with('status', 'password-updated');
    }
}
