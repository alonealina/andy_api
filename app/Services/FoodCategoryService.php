<?php

namespace App\Services;

use App\Repositories\FoodCategoryRepository;

class FoodCategoryService
{
    protected $foodCategoryRepository;

    /**
     * @param FoodCategoryRepository $foodCategoryRepository
     */
    public function __construct(FoodCategoryRepository $foodCategoryRepository)
    {
        $this->foodCategoryRepository = $foodCategoryRepository;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function store($params)
    {
        return $this->foodCategoryRepository->store($params);
    }
}
