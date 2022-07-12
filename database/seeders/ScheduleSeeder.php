<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $castIds = Cast::pluck('id')->toArray();
        foreach ($castIds as $castId) {
            for ($i=1; $i<28; $i++) {
                Schedule::create([
                    'cast_id' => $castId,
                    'year' => date('Y'),
                    'month' => date('m'),
                    'day' => $i,
                    'working_time' => [
                        [
                            'start' => '08:00',
                            'end' => '12:00'
                        ],
                        [
                            'start' => '14:00',
                            'end' => '18:00'
                        ],
                        [
                            'start' => '20:00',
                            'end' => '23:00'
                        ],
                    ],
                ]);
            }
        }
    }
}
