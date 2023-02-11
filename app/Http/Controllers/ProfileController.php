<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CodeCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'codes' => explode(';', Auth::user()->codeCard->codes),
        ]);
    }

    public function resetCodes(): RedirectResponse
    {
        Auth::user()->codeCard()->update([
            'codes' => CodeCard::generate(),
        ]);

        return Redirect::route('profile.edit');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))){
            return \redirect()->back()->with(
                'message_danger',
                'An error occurred while trying to update the profile information'
            );
        }

        Auth::user()->fill([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'phone_number' => $request->get('phone-number'),
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();

        Session::flash('message_success', 'Profile information updated successfully!');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
