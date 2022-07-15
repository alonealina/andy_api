<?php

namespace App\Services;

use App\Models\Drink;
use App\Repositories\DrinkRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DrinkService
{
    use SaveImagesUpload;

    /**
     * @var DrinkRepository
     */
    protected $drinkRepository;

    /**
     * @param DrinkRepository $drinkRepository
     */
    public function __construct(DrinkRepository $drinkRepository)
    {
        $this->drinkRepository = $drinkRepository;
    }

    /**
     * @param $params
     * @return mixed|null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->drinkRepository->store(array_merge($params, ['store_id' => Auth::user()->store_id]));
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
     * @return mixed
     */
    public function getList()
    {
        return $this->drinkRepository->getList();
    }

    /**
     * @param $params
     * @param Drink $drink
     * @return Drink|null
     */
    public function update($params, Drink $drink): ?Drink
    {
        DB::beginTransaction();
        try {
            $drink->update($params);
            if (isset($params['images'])) {
                $this->deleteImages($drink);
                $drink->images()->createMany($this->storeImages($params));
            }
            DB::commit();
            return $drink;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();
            return null;
        }
    }

    /**
     * @param Drink $drink
     * @return Drink|null
     */
    public function delete(Drink $drink): ?Drink
    {
        DB::beginTransaction();
        try {
            $drink->delete();
            $this->deleteImages($drink);
            DB::commit();
            return $drink;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();
            return null;
        }
    }

    /**
     * @return array
     */
    public function getImageDefault(): array
    {
        return Storage::disk()->files('images/defaults/drinks');
    }
}
