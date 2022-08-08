<?php

namespace App\Repositories;

use App\Enums\AccountRole;
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

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->belongsToBranch()
            ->whereRole(AccountRole::CUSTOMER)
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function getSuperAdmin()
    {
        return $this->model->where('role', AccountRole::SUPER_ADMIN)->first();
    }
}
