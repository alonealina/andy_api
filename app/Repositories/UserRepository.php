<?php

namespace App\Repositories;

use App\Models\Account;

class UserRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
       return Account::class;
    }
}
