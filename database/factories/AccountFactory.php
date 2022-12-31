<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'number' => rand(100000000000, 999999999999),
            'name' => fake()->word(),
            'balance' => rand(0, 100000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
