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
}
