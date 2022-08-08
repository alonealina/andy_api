<?php

namespace App\Services;

use App\Models\Drink;
use App\Repositories\DrinkCategoryRepository;
use App\Repositories\DrinkRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DrinkService
{
    use SaveImagesUpload, CheckBranch;

    /**
     * @var DrinkRepository
     */
    protected $drinkRepository;

    /**
     * @var DrinkCategoryRepository
     */
    protected $drinkCategoryRepository;

    /**
     * @param DrinkRepository $drinkRepository
     */
    public function __construct(
        DrinkRepository $drinkRepository,
        DrinkCategoryRepository $drinkCategoryRepository
    ) {
        $this->drinkRepository = $drinkRepository;
        $this->drinkCategoryRepository = $drinkCategoryRepository;
    }

    /**
     * @param $params
     * @return mixed|null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->drinkRepository->store($params);
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
    public function getList($params)
    {
        return isset($params['drink_category_id']) ?
            $this->drinkCategoryRepository->getAllDrinkOfBranch($params['drink_category_id']) :
            $this->drinkRepository->getList();
    }

    /**
     * @param $params
     * @param Drink $drink
     * @return Drink|null
     */
    public function update($params, Drink $drink): ?Drink
    {
        $this->checkBranch($drink);
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
        $this->checkBranch($drink);
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
        return Storage::disk()->files('upload-files/images/default/drinks');
    }

    /**
     * @param Drink $drink
     * @return array
     */
    public function show(Drink $drink): array
    {
        $this->checkBranch($drink);
        return $drink->load('drinkCategory.parent')->toArray();
    }
}
