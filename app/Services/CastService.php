<?php

namespace App\Services;

use App\Models\Cast;
use App\Repositories\CastRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CastService
{
    use SaveImagesUpload;

    /**
     * @var CastRepository
     */
    protected $castRepository;

    /**
     * @param CastRepository $castRepository
     */
    public function __construct(CastRepository $castRepository)
    {
        $this->castRepository = $castRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->castRepository->getList();
    }

    /**
     * @param $params
     * @return null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->castRepository->store(array_merge($params, ['store_id' => Auth::user()->store_id]));
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
     * @param $data
     * @param Cast $cast
     * @return mixed|null
     */
    public function update($data, Cast $cast)
    {
        DB::beginTransaction();
        try {
            $cast->update($data);
            // TODO Save upload images

            DB::commit();
            return $cast;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
