<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CodeCard;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Database\Seeders\CodecardSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            $user->codeCard()->create([
                'codes' => CodeCard::generate(),
            ]);

            $user->wallet()->create([
                'label' => 'Main',
                'number' => uniqid() . uniqid(),
                'balance' => 0,
            ]);
        });

        $user = User::where('email', $request->email)->first();

        event(new Registered($user));

        Auth::login($user);

        Session::flash('message_information',
            "Welcome to our MintWise, {$user->name}! \n Here, in the Profile section, you can view your security codes
            that will be used to authorize you. \n\n Please, hover on the codes, write them down and save them in a safe place!"
        );
        return redirect('/profile');
    }
}
