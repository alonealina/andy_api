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

    /**
     * Get schedule cast
     *
     * @param $params
     * @return array
     */
    public function getSchedule($params): array
    {
        return $this->model
            ->with(['scheduleDetails' => function ($query) use ($params) {
                $query->where([
                    'year' => $params['year'],
                    'month' => $params['month'],
                ]);
            }])
            ->where([
                'cast_id' => $params['cast_id'],
            ])->get()->toArray();
    }
}
