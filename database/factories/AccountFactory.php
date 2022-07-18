<?php

namespace Database\Factories;

use App\Enums\AccountRole;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $branchIds = Branch::pluck('id')->toArray();
        return [
            'branch_id' => array_rand($branchIds),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('123456789'),
            'role' => AccountRole::CUSTOMER,
            'name' => $this->faker->name(),
            'remember_token' => Str::random(10),
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
