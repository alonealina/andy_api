<?php

namespace App\Services;

use App\Models\Food;
use App\Repositories\FoodRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodService
{
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
    public function getList()
    {
        return $this->foodRepository->getList();
    }

    /**
     * @param $data
     * @return bool
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->foodRepository->store(array_merge($data, ['store_id' => Auth::user()->store_id]));
            // TODO Save upload images

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
     * @param $id
     * @return false|mixed|null
     */
    public function update($data, Food $food)
    {
        DB::beginTransaction();
        try {
            $food->update($data);
            // TODO Save upload images

            DB::commit();
            return $food;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
