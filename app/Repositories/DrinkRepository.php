<?php

namespace App\Repositories;

use App\Models\Drink;
use Illuminate\Support\Facades\Auth;

class DrinkRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Drink::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return Auth::user()->store->drinks->toArray();
    }
}
