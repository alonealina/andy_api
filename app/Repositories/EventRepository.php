<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return Auth::user()->store->events->toArray();
    }
}
