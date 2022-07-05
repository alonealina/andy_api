<?php

namespace App\Repositories;

use App\Models\Food;
use Illuminate\Support\Facades\Auth;

class FoodRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Food::class;

    }

    /**
     * @param $params
     * @return mixed
     */
    public function getList()
    {
        return Auth::user()->store->foods->toArray();
    }
}
