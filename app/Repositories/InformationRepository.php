<?php

namespace App\Repositories;

use App\Models\Information;
use Illuminate\Support\Facades\Auth;

class InformationRepository
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
        return Auth::user()->store->informations->toArray();
    }
}
