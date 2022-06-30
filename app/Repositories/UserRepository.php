<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
       return User::class;
    }
}
