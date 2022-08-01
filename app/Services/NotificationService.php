<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * @var NotificationRepository
     */
    protected $notificationRepository;

    /**
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @return mixed
     */
    public function readNotify($params)
    {
        return Auth::user()->notifications()
            ->when(isset($params['type']), function ($query) use ($params){
                $query->whereType($params['type']);
            })
            ->whereNull('read_at')->update([
                'read_at' => now()
            ]);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return Auth::user()->notifications()->whereNull('read_at')->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->notificationRepository->getCount();
    }
}
