<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return News::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->orderBy('created_at', 'DESC')->get()->toArray();
    }
}
