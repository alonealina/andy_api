<?php

namespace Database\Seeders;

use App\Enums\MaintainRole;
use App\Models\Branch;
use App\Models\MaintainHistory;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintainHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maintain_histories')->truncate();
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            MaintainHistory::create([
                'branch_ids' => array_rand($branchIds, rand(1, count($branchIds))),
                'role' => MaintainRole::ADMIN,
                'message' => $faker->text(),
                'start_time' => Carbon::yesterday(),
                'end_time' => Carbon::today()
            ]);
            MaintainHistory::create([
                'branch_ids' => array_rand($branchIds, rand(1, count($branchIds))),
                'role' => MaintainRole::USER,
                'message' => $faker->text(),
                'start_time' => Carbon::yesterday(),
                'end_time' => Carbon::today()
            ]);
        }
    }
}

