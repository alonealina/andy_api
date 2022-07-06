<?php

namespace App\Services;

use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param $params
     * @return mixed|null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->eventReposiory->store(array_merge($params, ['store_id' => Auth::user()->store_id]));
            // TODO Save upload images

            DB::commit();
            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
