<?php

namespace App\Repositories;

use App\Models\Information;
use Illuminate\Support\Facades\Auth;

class InformationRepository extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return Information::class;

    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->belongsToBranch()
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
