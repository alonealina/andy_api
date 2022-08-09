<?php

namespace App\Repositories;

use App\Models\MaintainHistory;

class MaintainHistoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return MaintainHistory::class;
    }

    /**
     * @return mixed
     */
    public function getMaintainList()
    {
        return $this->model->orderByDesc('start_time')->get()->toArray();
    }
}
