<?php

namespace App\Repositories;

use App\Models\Drink;

class DrinkRepository extends BaseRepository
{
    public function model()
    {
        return Drink::class;
    }
}
