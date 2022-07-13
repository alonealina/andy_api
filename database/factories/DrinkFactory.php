<?php

namespace Database\Factories;

use App\Models\DrinkCategory;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $storeIds = Store::pluck('id')->toArray();
        $categoriesId = DrinkCategory::pluck('id')->toArray();
        return [
            'store_id' => array_rand($storeIds),
            'drink_category_id' => array_rand($categoriesId),
            'name' => $this->faker->name(),
            'price' => $this->faker->randomDigit(),
            'description' => $this->faker->text(),
        ];
    }

    /**
     * @return DrinkFactory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
