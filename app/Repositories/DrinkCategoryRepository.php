<?php

namespace App\Repositories;

use App\Models\DrinkCategory;

class DrinkCategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return DrinkCategory::class;
    }
}
