<?php

namespace App\Repositories;

use App\Enums\AccountRole;
use App\Models\Background;
use Illuminate\Support\Facades\Auth;

class BackgroundRepository extends BaseRepository
{
    public function model(): string
    {
        return Background::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->belongsToBranch()->orderBy('position')->get();
    }

    /**
     * @return mixed
     */
    public function getOldImages()
    {
        return $this->model->where('branch_id',Auth::user()->branch_id)
            ->where('role_background',AccountRole::ADMIN)->get();
    }
}
