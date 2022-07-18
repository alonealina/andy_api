<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Branch;
use App\Models\StoreCategory;
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
        $branchIds = Branch::pluck('id')->toArray();
        $categoriesId = StoreCategory::pluck('id')->toArray();
        return [
            'branch_id' => array_rand($branchIds),
            'store_category_id' => array_rand($categoriesId),
            'name' => $this->faker->streetName(),
            'post_code_1' => $this->faker->numberBetween(1111, 9999),
            'post_code_2' => $this->faker->numberBetween(1111, 9999),
            'address' => $this->faker->address(),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'payment_method' => array_rand(PaymentMethod::getValues(), rand(1, 4)),
            'counter_count' => rand(10, 50),
            'table_count' => rand(10, 50),
            'room_count' => rand(10, 50),
            'stand_count' => rand(10, 50),
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
