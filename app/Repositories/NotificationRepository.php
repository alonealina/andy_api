<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Notification::class;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->model
            ->selectRaw('type, COUNT(*) as count')
            ->whereAccountId(Auth::user()->id)
            ->whereNull('read_at')
            ->groupBy('type')
            ->get();
    }
}
