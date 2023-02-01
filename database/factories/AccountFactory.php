<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => 1,
            'number' => fake()->iban('LV', 'HABA'),
            'label' => fake()->word(),
            'currency' => 'EUR',
            'balance' => rand(0, 100000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
