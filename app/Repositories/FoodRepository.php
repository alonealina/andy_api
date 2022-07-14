<?php

namespace App\Repositories;

use App\Enums\InventoryStatus;
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
     * @return mixed
     */
    public function getList()
    {
        return Auth::user()->store->foods->where('status', InventoryStatus::ON_SALE)->toArray();
    }
}
