<?php

namespace App\Services;

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
    public function getList(): array
    {
        return $this->drinkCategoryRepository->getAll()->toArray();
    }

    /**
     * @param $drinkCategory
     * @return mixed
     */
    public function getByCategory($drinkCategory)
    {
        return $drinkCategory->getAllDrinkCategory()->load('drinks')->toArray();
    }
}
