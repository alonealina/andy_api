<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
    public function getList()
    {
        return $this->accountRepository->getList();
    }

    /**
     * @param $params
     * @return null
     */
    public function store($data)
    {
        return $this->accountRepository->create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'password_show' => $data['password'],
            'role' => AccountRole::CUSTOMER,
            'name' => $data['name']
        ]);
    }

    /**
     * @param $params
     * @param Account $account
     * @return Account
     */
    public function update($params, Account $account): Account
    {
        $account->update($params);
        return $account;
    }

    /**
     * @param Account $account
     * @return Account
     */
    public function delete(Account $account): Account
    {
        $account->delete();
        return $account;
    }
}
