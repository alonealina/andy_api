<?php

namespace App\Repositories;

use App\Models\StoreCategory;

class StoreCategoryRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
       return StoreCategory::class;
    }
}
