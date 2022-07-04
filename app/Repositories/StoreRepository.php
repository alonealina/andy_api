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
}
