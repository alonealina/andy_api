<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Schedule::class;
    }
}
