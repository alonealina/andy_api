<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $accounts = Account::where('branch_id', 1)->pluck('id')->toArray();
        $day = rand(strtotime('-5 year'),time());
        return [
            'account_id' => $accounts[array_rand($accounts)],
            'total_amount' => rand(1, 100) * 1000,
            'status' => OrderStatus::PAID,
            'created_at' => $day,
            'updated_at' => $day
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
