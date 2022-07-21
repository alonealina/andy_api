<?php

namespace App\Repositories;

use App\Models\FoodCategory;

class FoodCategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return FoodCategory::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->belongsToBranch()->get()->toArray();
    }
}
