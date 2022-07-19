<?php

namespace App\Services;

use App\Models\Cast;
use App\Repositories\CastRepository;
use App\Repositories\ScheduleRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;

class CastService
{
    use SaveImagesUpload, CheckBranch;

    /**
     * @var CastRepository
     */
    protected $castRepository;

    /**
     * @var ScheduleRepository
     */
    protected $scheduleRepository;


    /**
     * @param CastRepository $castRepository
     * @param ScheduleRepository $scheduleRepository
     */
    public function __construct(
        CastRepository $castRepository,
        ScheduleRepository $scheduleRepository
    ) {
        $this->castRepository = $castRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->castRepository->getList();
    }

    /**
     * @param $params
     * @return null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->castRepository->store($params);
            $newRecord->images()->createMany($this->storeImages($params));
            DB::commit();
            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param $data
     * @param Cast $cast
     * @return mixed|null
     */
    public function update($data, Cast $cast)
    {
        DB::beginTransaction();
        try {
            $cast->update($data);
            $this->updateImages($cast, $data);
            DB::commit();
            return $cast;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Cast $cast
     * @return Cast|null
     */
    public function destroy(Cast $cast)
    {
        DB::beginTransaction();
        try {
            $cast->delete();
            $this->deleteImages($cast);
            DB::commit();
            return $cast;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Cast $cast
     * @param $params
     * @return array
     */
    public function getSchedule(Cast $cast, $params)
    {
        return $cast->load([
            'schedules' => function ($query) use ($params) {
                $query->where([
                    'year' => $params['year'],
                    'month' => $params['month'],
                ]);
            }
        ])->toArray();
    }

    /**
     * @param Cast $cast
     * @param $data
     * @return Cast|null
     */
    public function setSchedule(Cast $cast, $data)
    {
        $this->checkBranch($cast);
        DB::beginTransaction();
        try {
            $cast->update([
                'is_service' => $data['is_service'],
                'is_overtime' => $data['is_overtime']
            ]);
            foreach ($data['schedules'] as $schedule) {
                $this->scheduleRepository->updateOrCreate([
                    'cast_id' => $cast->id,
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'day' => $schedule['day'],
                ], [
                    'working_time' => $schedule['working_time']
                ]);
            }
            DB::commit();
            return $cast;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param $cast
     * @param $data
     * @return void
     */
    public function updateImages($cast, $data)
    {
        if (!isset($data['images'])) {
            $this->deleteImages($cast);
            return;
        }
        $oldImages = $cast->images;
        $saveImages = [];
        foreach ($data['images'] as $key => $newImage) {
            $record = $oldImages->where('file_name', $newImage['file_name'])->first();
            if (!empty($record)) {
                $record->order = $key;
                $record->save();
                $saveImages[] = $newImage['file_name'];
            } else {
                $cast->images()->create($this->saveImagesToDisk($key, $newImage['file']));
            }
        }
        $this->deleteImagesCloud($oldImages->whereNotIn('file_name', $saveImages));
    }
}
