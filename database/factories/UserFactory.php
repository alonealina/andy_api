<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $storeIds = Store::pluck('id')->toArray();
        return [
            'store_id' => array_rand($storeIds),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('123456789'),
            'role' => UserRole::CUSTOMER,
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
