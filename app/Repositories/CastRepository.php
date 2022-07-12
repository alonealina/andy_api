<?php

namespace App\Repositories;

use App\Models\Cast;
use Illuminate\Support\Facades\Auth;

class CastRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
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
