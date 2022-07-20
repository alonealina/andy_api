<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Account::class;
    }

    public function getList()
    {
        return $this->model->belongsToBranch()
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
