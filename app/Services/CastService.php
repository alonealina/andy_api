<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Models\Cast;
use App\Repositories\AccountRepository;
use App\Repositories\CastRepository;
use App\Repositories\ScheduleRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @param CastRepository $castRepository
     * @param ScheduleRepository $scheduleRepository
     * @param AccountRepository $accountRepository
     */
    public function __construct(
        CastRepository $castRepository,
        ScheduleRepository $scheduleRepository,
        AccountRepository $accountRepository
    ) {
        $this->castRepository = $castRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->accountRepository = $accountRepository;
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
            $account = $this->accountRepository->create([
                'username' => $params['username'],
                'password' => Hash::make($params['password']),
                'role' => AccountRole::CAST,
                'name' => $params['name']
            ]);
            $newRecord = $this->castRepository->store(array_merge(['account_id' => $account->id], $params));
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
     * @return Cast|null
     */
    public function update($data, Cast $cast)
    {
        $this->checkBranch($cast);
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
     * @return Cast
     */
    public function show(Cast $cast): Cast
    {
        $this->checkBranch($cast);
        return $cast;
    }

    /**
     * @param $data
     * @param Cast $cast
     * @return Cast|null
     */
    public function updateAccount($data, Cast $cast): ?Cast
    {
        $this->checkBranch($cast);
        DB::beginTransaction();
        try {
            $cast->account()->update(['password' => Hash::make($data['password'])]);
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
    public function destroy(Cast $cast): ?Cast
    {
        $this->checkBranch($cast);
        DB::beginTransaction();
        try {
            $cast->delete();
            $cast->account()->delete();
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
    public function getSchedule(Cast $cast, $params): array
    {
        return $cast->load([
            'schedules' => function ($query) use ($params) {
                $query->where([
                    'year' => $params['year'],
                    'month' => $params['month'],
                ])
                    ->orderBy('day');
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
}
