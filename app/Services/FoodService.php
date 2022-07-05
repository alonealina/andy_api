<?php

namespace App\Services;

use App\Repositories\FoodRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
     * @param $params
     * @return mixed
     */
    public function getList()
    {
        return $this->foodRepository->getList();
    }

    /**
     * @param $request
     * @return bool
     * @throws \Exception
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

    public function destroy($food)
    {
        DB::beginTransaction();
        try {
            $deleteRecord = $food->delete();
            // TODO Save upload images
            DB::commit();
            return $deleteRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
