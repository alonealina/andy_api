<?php

namespace App\Services;

use App\Models\Information;
use App\Repositories\InformationRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InformationService
{
    use SaveImagesUpload;

    /**
     * @var InformationRepository
     */
    protected $informationRepository;

    /**
     * Construct function
     *
     * @param InformationRepository $informationRepository
     */
    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->informationRepository->getList();
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->informationRepository->store(array_merge($data,
                ['store_id' => Auth::user()->store_id]));
            $newRecord->images()->createMany($this->storeImages($data['images']));
            DB::commit();

            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return null;
        }
    }

    /**
     * @param $params
     * @param Information $information
     * @return Information|null
     */
    public function update($params, Information $information): ?Information
    {
        DB::beginTransaction();
        try {
            $information->update($params);
            // TODO Save upload images
            DB::commit();

            return $information;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();

            return null;
        }
    }
}
