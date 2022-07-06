<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    /**
     * @var EventRepository
     */
    protected $eventReposiory;

    /**
     * @param EventRepository $eventReposiory
     */
    public function __construct(EventRepository $eventReposiory)
    {
        $this->eventReposiory = $eventReposiory;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->eventReposiory->getList();
    }
}
