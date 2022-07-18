<?php

namespace App\Services;

use App\Models\Store;
use App\Repositories\StoreRepository;
use App\Traits\CheckBranch;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;

class StoreService
{
    use SaveImagesUpload, CheckBranch;

    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * Construct function
     *
     * @param StoreRepository $storeRepository
     */
    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get list store
     *
     * @param $params
     * @return array
     */
    public function getList($params): array
    {
        return $this->storeRepository->getList($params);
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->storeRepository->store($data);
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
     * @param array $data
     * @param Store $store
     * @return Store|null
     */
    public function update(array $data, Store $store): ?Store
    {
        DB::beginTransaction();
        try {
            $store->update($data);
            // TODO Save images upload
            DB::commit();
            return $store;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Store $store
     * @return Store|null
     */
    public function destroy(Store $store): ?Store
    {
        DB::beginTransaction();
        try {
            $store->delete();
            $this->deleteImages($store);
            DB::commit();
            return $store;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * Get system information
     *
     * @param Store $store
     * @return mixed
     */
    public function getSystemInformation(Store $store)
    {
        return $store->systemInformation->toArray();
    }

    /**
     * Update system information
     *
     * @param $data
     * @param Store $store
     * @return mixed
     */
    public function updateSystemInformation($data, Store $store)
    {
        $this->checkBranch($store);
        $store->systemInformation()->update($data);
        return $store->systemInformation->toArray();
    }
}
