<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
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
            'price' => $this->faker->randomDigit(),
            'description' => $this->faker->text(),
        ];
    }
}
