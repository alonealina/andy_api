<?php

namespace App\Repositories;

use App\Models\Cast;
use Illuminate\Support\Facades\DB;

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
        return $this->model->belongsToBranch()
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }

    public function show($cast)
    {
       return $cast->images()->orderBy('order','asc')->get()->toArray();
    }
}
