<?php

namespace App\Services;

use App\Models\Information;
use App\Repositories\InformationRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;

class InformationService
{
    use SaveImagesUpload, CheckBranch;

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
            $newRecord = $this->informationRepository->store($data);
            $newRecord->images()->createMany($this->storeImages($data));
            DB::commit();

            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            return null;
        }
    }

    /**
     * @param Information $information
     * @return array|Information
     */
    public function show(Information $information): array
    {
        $this->checkBranch($information);
        return $information->toArray();
    }

    /**
     * @param $data
     * @param Information $information
     * @return Information|null
     */
    public function update($data, Information $information): ?Information
    {
        $this->checkBranch($information);
        DB::beginTransaction();
        try {
            $information->update($data);
            if (isset($data['images'])) {
                $this->deleteImages($information);
                $information->images()->createMany($this->storeImages($data));
            }
            DB::commit();
            return $information;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();
            return null;
        }
    }

    /**
     * @param Information $information
     * @return Information|null
     */
    public function destroy(Information $information): ?Information
    {
        $this->checkBranch($information);
        DB::beginTransaction();
        try {
            $information->delete();
            $this->deleteImages($information);
            DB::commit();
            return $information;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
