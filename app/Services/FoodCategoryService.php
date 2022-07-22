<?php

namespace App\Services;

use App\Models\FoodCategory;
use App\Repositories\FoodCategoryRepository;
use App\Traits\CheckBranch;

class FoodCategoryService
{
    use CheckBranch;

    /**
     * @var FoodCategoryRepository
     */
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

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->foodCategoryRepository->getList();
    }

    /**
     * @param FoodCategory $foodCategory
     * @return FoodCategory
     */
    public function delete(FoodCategory $foodCategory): FoodCategory
    {
        $this->checkBranch($foodCategory);
        $foodCategory->delete();
        return $foodCategory;
    }

    /**
     * @param $params
     * @param FoodCategory $foodCategory
     * @return FoodCategory
     */
    public function update($params, FoodCategory $foodCategory): FoodCategory
    {
        $this->checkBranch($foodCategory);
        $foodCategory->update($params);
        return $foodCategory;
    }
}
