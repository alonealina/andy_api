<?php

namespace Database\Seeders;

use App\Enums\OrderDetailStatus;
use App\Models\Drink;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drinks = Drink::get();
        $users = User::pluck('id')->toArray();
        foreach ($drinks as $drink) {
            for($i=1; $i<10; $i++) {
                $drink->orderDetails()->create([
                    'user_id' => array_rand($users),
                    'price' => $drink->price,
                    'quantity' => rand(1, 5),
                    'status' => array_rand(OrderDetailStatus::getValues()),
                ]);
            }
        }

        $foods = Food::get();
        foreach ($foods as $food) {
            for($i=1; $i<10; $i++) {
                $food->orderDetails()->create([
                    'user_id' => array_rand($users),
                    'price' => $food->price,
                    'quantity' => rand(1, 5),
                    'status' => array_rand(OrderDetailStatus::getValues()),
                ]);
            }
        }
    }
}
