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
}
