<?php

namespace App\Repositories;

use App\Models\SystemInformation;

class SystemInformationRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
       return SystemInformation::class;
    }

    /**
     * @return mixed
     */
    public function getSystemInformation()
    {
        return $this->model->belongsToBranch()->first();
    }
}
