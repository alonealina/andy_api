<?php

namespace App\Services;

use App\Repositories\StoreCategoryRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Support\Facades\DB;

class StoreCategoryService
{
    use SaveImagesUpload;

    /**
     * @var StoreCategoryRepository
     */
    protected $storeCategoryRepository;

    /**
     * Construct function
     *
     * @param StoreCategoryRepository $storeCategoryRepository
     */
    public function __construct(StoreCategoryRepository $storeCategoryRepository)
    {
        $this->storeCategoryRepository = $storeCategoryRepository;
    }

    /**
     * Get list store
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->storeCategoryRepository->getAll()->toArray();
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->storeCategoryRepository->store($data);
            $newRecord->images()->createMany($this->storeImages($data['images']));
            DB::commit();
            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }
}
