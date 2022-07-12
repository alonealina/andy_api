<?php

namespace App\Services;

use App\Models\Schedule;
use App\Repositories\ScheduleDetailRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /**
     * @var ScheduleRepository
     */
    protected $scheduleRepository;

    /**
     * @var ScheduleDetailRepository
     */
    protected $scheduleDetailRepository;

    /**
     * @param ScheduleRepository $scheduleRepository
     * @param ScheduleDetailRepository $scheduleDetailRepository
     */
    public function __construct(
        ScheduleRepository $scheduleRepository,
        ScheduleDetailRepository $scheduleDetailRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
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

    /**
     * Update schedule
     *
     * @param $data
     * @param Schedule $schedule
     * @return Schedule|null
     */
    public function update($data, Schedule $schedule): ?Schedule
    {
        DB::beginTransaction();
        try {
            $schedule->update([
                'is_service' => $data['is_service'],
                'is_overtime' => $data['is_overtime']
            ]);
            foreach ($data['schedule_details'] as $scheduleDetail) {
                $this->scheduleDetailRepository->updateOrCreate([
                    'schedule_id' => $schedule->id,
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'day' => $scheduleDetail['day'],
                ], [
                    'working_time' => $scheduleDetail['working_time']
                ]);
            }
            DB::commit();
            return $schedule;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
