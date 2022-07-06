<?php

namespace App\Repositories;

use App\Models\Store;

class StoreRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
       return Store::class;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getList($params)
    {
        return $this->model
            ->when(isset($params['store_category_id']), function ($query) use ($params) {
                $query->where('store_category_id', $params['store_category_id']);
            })->get()->toArray();
    }
}
