<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseAccountSeeder extends Seeder
{
//    seed the database with one user that has 3 accounts, one GBP, one EUR, one USD
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@user.lv',
        ]);

        $user->codeCard()->create([
            'codes' => '1;2;3;4;5;6;7;8;9;10;11;12',
        ]);

        Account::factory()->create([
            'label' => 'UK Account',
            'user_id' => $user->id,
            'balance' => '1063',
            'currency' => 'GBP',

        ]);
        Account::factory()->create([
            'label' => 'EUR Account',
            'number' => "LV55HABA456W4U661JAB1",
            'user_id' => $user->id,
            'balance' => '10654654',
            'currency' => 'EUR',
        ]);
        Account::factory()->create([
            'label' => 'USD Account',
            'user_id' => $user->id,
            'currency' => 'USD',
        ]);

        Transaction::factory(23)->create([
            'account_number' => "LV55HABA456W4U661JAB1",
            'beneficiary_account_number' => fake()->iban('LV', 'HABA'),
        ]);
        Transaction::factory(23)->create([
            'account_number' => fake()->iban('LV', 'HABA'),
            'beneficiary_account_number' => "LV55HABA456W4U661JAB1",
        ]);

        $user->assets()->createMany([
            [
                'symbol' => 'BTC',
                'average_cost' => 365.54843,
                'amount' => 1.352321,
                'type' => 'Crypto',
            ],
            [
                'symbol' => 'ADA',
                'average_cost' => 0.8154,
                'amount' => 1268.352321,
                'type' => 'Crypto',
            ],
            [
                'symbol' => 'DOT',
                'average_cost' => 12.54843,
                'amount' => 56.352321,
                'type' => 'Crypto',
            ],
        ]);
    }
}
