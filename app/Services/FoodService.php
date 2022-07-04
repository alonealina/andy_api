<?php

namespace App\Services;

use App\Repositories\FoodRepository;

class FoodService
{
    /**
     * @var FoodRepository
     */
    protected $foodRepository;

    /**
     * Construct function
     *
     * @param FoodRepository $foodRepository
     */
    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getList($params)
    {
        return $this->foodRepository->getList($params);
    }

}
