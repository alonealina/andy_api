<?php

namespace App\Services;

use App\Models\DrinkCategory;
use App\Repositories\DrinkCategoryRepository;

class DrinkCategoryService
{
    protected $drinkCategoryRepository;

    /**
     * @param DrinkCategoryRepository $drinkCategoryRepository
     */
    public function __construct(DrinkCategoryRepository $drinkCategoryRepository)
    {
        $this->drinkCategoryRepository = $drinkCategoryRepository;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->drinkCategoryRepository->getListParent();
    }

    /**
     * @param $params
     * @param DrinkCategory $drinkCategory
     * @return DrinkCategory
     */
    public function update($params, DrinkCategory $drinkCategory)
    {
        $drinkCategory->update($params);
        return $drinkCategory;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function store($params)
    {
        return $this->drinkCategoryRepository->store($params);
    }

    /**
     * @param DrinkCategory $drinkCategory
     * @return DrinkCategory
     */
    public function delete(DrinkCategory $drinkCategory): DrinkCategory
    {
        $drinkCategory->delete();
        return $drinkCategory;
    }

    /**
     * @param DrinkCategory $drinkCategory
     * @return DrinkCategory|mixed
     */
    public function show(DrinkCategory $drinkCategory)
    {
        return $drinkCategory->load('childs')->toArray();
    }
}
