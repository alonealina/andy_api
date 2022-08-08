<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Enums\NotificationType;
use App\Events\CreateNotification;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\CheckBranch;

class AccountService
{
    use CheckBranch;

    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @var NotificationRepository
     */
    protected $notificationRepository;

    /**
     * @param AccountRepository $accountRepository
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(
        AccountRepository $accountRepository,
        NotificationRepository $notificationRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->notificationRepository = $notificationRepository;
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
        $this->checkBranch($account);
        $account->update($params);
        return $account;
    }

    /**
     * @param Account $account
     * @return Account
     */
    public function delete(Account $account): Account
    {
        $this->checkBranch($account);
        $account->delete();
        return $account;
    }

    /**
     * @return mixed
     */
    public function messageSOS()
    {
        event(new CreateNotification(NotificationType::SOS));
        return $this->notificationRepository->create([
            'id' => Str::uuid(),
            'account_id' => Auth::user()->getAdminBranch()->id,
            'type' => NotificationType::SOS,
            'notifiable_type' => Account::class,
            'notifiable_id' => Auth::user()->id,
            'data' => __('messages.notification')[NotificationType::SOS]
        ]);
    }
}
