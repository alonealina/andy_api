<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Notification::class;
    }
}
