<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventService
{
    use SaveImagesUpload;

    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->eventRepository->getList();
    }

    /**
     * @param $params
     * @return mixed|null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->eventRepository->store(array_merge($params, ['store_id' => Auth::user()->store_id]));
            $newRecord->images()->createMany($this->storeImages($params['images']));
            DB::commit();
            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Event $event
     * @return Event|null
     */
    public function delete(Event $event): ?Event
    {
        DB::beginTransaction();
        try {
            $event->delete();
            $this->deleteImages($event);
            DB::commit();
            return $event;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();
            return null;
        }
    }
}
