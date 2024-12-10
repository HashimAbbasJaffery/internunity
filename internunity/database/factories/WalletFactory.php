<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['App\Models\User', 'App\Models\Company'];
        return [
            "walletable_type" => 'App\Models\Company',
            "walletable_id" => 1,
            "balance" => fake()->numberBetween(0, 10_000),
            "status" => 1
        ];
    }
}
