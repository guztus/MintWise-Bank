<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $amount = $this->faker->numberBetween(1, 100000);
        return [
            'account_number' => $this->faker->randomElement(['LV31HABA217Q361TTD06J', 'LV26HABAE9QAB89FEG396', 'LV26HABAE9QAB89FEG397', 'LV26HABAE9QAB89FEG398', 'LV26HABAE9QAB89FEG399']),
            'beneficiary_account_number' =>  $this->faker->randomElement(['LV31HABA217Q361TTD06J', 'LV26HABAE9QAB89FEG396', 'LV26HABAE9QAB89FEG397', 'LV26HABAE9QAB89FEG398', 'LV26HABAE9QAB89FEG399']),
            'description' => $this->faker->sentence(),
            'type' => 'transfer',
            'amount_payer' => $amount,
            'currency_payer' => 'EUR',
            'amount_beneficiary' => $amount,
            'currency_beneficiary' => 'EUR',
        ];
    }
}
