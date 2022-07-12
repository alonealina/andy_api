<?php

namespace App\Services;

use App\Repositories\ScheduleRepository;

class ScheduleService
{
    /**
     * @var ScheduleRepository
     */
    protected $scheduleRepository;

    /**
     * @param ScheduleRepository $scheduleRepository
     */
    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Get schedule cast
     *
     * @param $params
     * @return array
     */
    public function getSchedule($params): array
    {
        return $this->scheduleRepository->getSchedule($params);
    }
}
