<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class CastFactory extends Factory
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
            'height' => $this->faker->randomFloat(2, 1, 2 ),
            'blood_type' => $this->faker->numberBetween(1,8),
            'hobbit' => $this->faker->word(),
            'type_person' => $this->faker->word(),
            'dream' => $this->faker->word(),
            'fetish' => $this->faker->word(),
            'slogan' => $this->faker->word(),
            'instagram_url' => $this->faker->url(),
            'special_skill' => $this->faker->word(),
        ];
    }
}
