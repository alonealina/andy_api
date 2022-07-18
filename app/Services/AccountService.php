<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountService
{
    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * Construct function
     *
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @return Collection|Model[]
     */
    public function getAll()
    {
        return $this->accountRepository->getAll();
    }
}
