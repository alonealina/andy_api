<?php

namespace App\Services;

use App\Models\Food;
use App\Repositories\FoodRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodService
{
    use SaveImagesUpload, CheckBranch;

    /**
     * @var FoodRepository
     */
    protected $foodRepository;

    /**
     * Construct function
     *
     * @param FoodRepository $foodRepository
     */
    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    /**
     * @return mixed
     */
    public function getList($params)
    {
        return $this->foodRepository->getList($params);
    }

    /**
     * @param $data
     * @return mixed|null
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->foodRepository->store($data);
            $newRecord->images()->createMany($this->storeImages($data));
            DB::commit();

            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return null;
        }
    }

    /**
     * @param Food $food
     * @return Food
     */
    public function show(Food $food)
    {
        $this->checkBranch($food);
        return $food;
    }

    /**
     * @param $data
     * @param Food $food
     * @return Food|null
     */
    public function update($data, Food $food)
    {
        $this->checkBranch($food);
        DB::beginTransaction();
        try {
            $food->update($data);
            if (isset($data['images'])) {
                $this->deleteImages($food);
                $food->images()->createMany($this->storeImages($data));
            }
            DB::commit();

            return $food;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return null;
        }
    }

    /**
     * @param Food $food
     * @return Food|null
     */
    public function destroy(Food $food): ?Food
    {
        $this->checkBranch($food);
        DB::beginTransaction();
        try {
            $food->delete();
            $this->deleteImages($food);
            DB::commit();

            return $food;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return null;
        }
    }

    /**
     * @return array
     */
    public function getImageDefault(): array
    {
        return Storage::disk()->files('upload-files/images/default/foods');
    }
}
