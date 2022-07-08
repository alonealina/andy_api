<?php

namespace App\Repositories;

use App\Models\Cast;
use Illuminate\Support\Facades\Auth;

class CastRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Cast::class;

    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return Auth::user()->store->casts->toArray();
    }
}
