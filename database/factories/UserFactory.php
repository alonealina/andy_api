<?php

namespace Database\Factories;

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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'number_phone' => '0' . $this->faker->numberBetween(11111111, 99999999),
            'password' => Hash::make('123456789'),
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
