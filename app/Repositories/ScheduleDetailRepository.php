<?php

namespace App\Repositories;

use App\Models\ScheduleDetail;

class ScheduleDetailRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return ScheduleDetail::class;
    }
}
