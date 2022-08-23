<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Cast;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cast::truncate();
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();

        foreach ($branchIds as $branchId) {
            for ($i = 0; $i < 50; $i++) {
                $name = $faker->name();
                $account = Account::create([
                    'branch_id' => $branchId,
                    'username' => $faker->unique()->userName,
                    'password' => Hash::make('12345678'),
                    'role' => AccountRole::CAST,
                    'name' => $name,
                ]);
                Cast::create([
                    'branch_id' => $branchId,
                    'account_id' => $account->id,
                    'name' => $name,
                    'height' => $faker->randomFloat(2, 150, 170),
                    'blood_type' => $faker->numberBetween(1, 8),
                    'hobbit' => $faker->word(),
                    'type_person' => $faker->word(),
                    'dream' => $faker->word(),
                    'fetish' => $faker->word(),
                    'slogan' => $faker->word(),
                    'instagram_url' => $faker->url(),
                    'special_skill' => $faker->word(),
                ]);
            }
        }
    }
}
