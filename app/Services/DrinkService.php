<?php

namespace App\Services;

use App\Repositories\DrinkRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DrinkService
{
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
     * @return mixed
     */
    public function getList()
    {
        return $this->drinkRepository->getList();
    }
}
