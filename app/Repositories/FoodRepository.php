<?php

namespace App\Repositories;

use App\Models\Food;

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
     * @param $params
     * @return mixed
     */
    public function getList($params)
    {
        return $this->model->when(isset($params['store_id']), function ($query) use ($params) {
            $query->where('store_id', $params['store_id']);
        })->get()->toArray();
    }

}
