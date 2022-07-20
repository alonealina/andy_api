<?php

namespace Database\Seeders;

use App\Enums\OrderDetailStatus;
use App\Models\Drink;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_details')->truncate();
        $orders = Order::all();
        $drinks = Drink::select('id', 'price')->limit(5)->get()->toArray();
        $foods = Food::select('id', 'price')->limit(5)->get()->toArray();
        foreach ($orders as $order) {
            for ($i = 0; $i < 5; $i++) {
                $order->orderDetails()->create([
                    'orderable_id' => $drinks[$i]['id'],
                    'orderable_type' => Drink::class,
                    'price' => $drinks[$i]['price'],
                    'quantity' => 1,
                    'amount' => $drinks[$i]['price'],
                    'status' => OrderDetailStatus::PENDING,
                ]);
                $order->orderDetails()->create([
                    'orderable_id' => $foods[$i]['id'],
                    'orderable_type' => Food::class,
                    'price' => $foods[$i]['price'],
                    'quantity' => 1,
                    'amount' => $foods[$i]['price'],
                    'status' => OrderDetailStatus::PENDING,
                ]);
            }
        }
    }
}
