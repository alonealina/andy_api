<?php

namespace App\Repositories;

use App\Models\Background;

class BackgroundRepository extends BaseRepository
{
    public function model(): string
    {
        return Background::class;
    }

    /**
     * @param $column
     * @param $values
     * @return mixed
     */
    public function whereNotIn($column, $values)
    {
        return $this->model()::whereNotIn($column, $values);
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->belongsToBranch()->get();
    }
}
