<?php

namespace Database\Factories;

use App\Models\DrinkCategory;
use App\Models\Branch;
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
        $branchIds = Branch::pluck('id')->toArray();
        $categoriesId = DrinkCategory::where('parent_id','!=',null)->pluck('id')->toArray();
        return [
            'branch_id' => array_rand($branchIds),
            'drink_category_id' => $categoriesId[array_rand($categoriesId)],
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
