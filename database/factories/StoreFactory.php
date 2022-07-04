<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName(),
            'post_code_1' => $this->faker->numberBetween(111, 999),
            'post_code_2' => $this->faker->numberBetween(1111, 9999),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'payment_method' => json_encode(array_rand(PaymentMethod::getValues(), rand(1, 4))),
            'counter_count' => rand(1, 10),
            'table_count' => rand(1, 10),
            'room_count' => rand(1, 10),
            'stand_count' => rand(1, 10),
            'hotline' => '1900' . rand(11111, 99999),
            'homepage_url' => $this->faker->url(),
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
