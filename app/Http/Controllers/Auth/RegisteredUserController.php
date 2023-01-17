<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Database\Seeders\CodecardSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
            'code_1' => fake()->numberBetween(10000,99999),
            'code_2' => fake()->numberBetween(10000,99999),
            'code_3' => fake()->numberBetween(10000,99999),
            'code_4' => fake()->numberBetween(10000,99999),
            'code_5' => fake()->numberBetween(10000,99999),
            'code_6' => fake()->numberBetween(10000,99999),
            'code_7' => fake()->numberBetween(10000,99999),
            'code_8' => fake()->numberBetween(10000,99999),
            'code_9' => fake()->numberBetween(10000,99999),
            'code_10' => fake()->numberBetween(10000,99999),
            'code_11' => fake()->numberBetween(10000,99999),
            'code_12' => fake()->numberBetween(10000,99999),
        ]);

        });

        $user = User::where('email', $request->email)->first();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
