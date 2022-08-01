<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Enums\MaintainRole;
use App\Enums\MaintainStatus;
use App\Enums\PositionBackground;
use App\Models\Branch;
use App\Repositories\AccountRepository;
use App\Repositories\BackgroundRepository;
use App\Repositories\BranchRepository;
use App\Repositories\MaintenanceRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BranchService
{
    use SaveImagesUpload;

    /**
     * @var BranchRepository
     */
    protected $branchRepository;

    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @var MaintenanceRepository
     */
    protected $maintenanceRepository;

    /**
     * @var BackgroundRepository
     */
    protected $backgroundRepository;

    /**
     * @param BranchRepository $branchRepository
     * @param AccountRepository $accountRepository
     * @param MaintenanceRepository $maintenanceRepository
     * @param BackgroundRepository $backgroundRepository
     */
    public function __construct(
        BranchRepository $branchRepository,
        AccountRepository $accountRepository,
        MaintenanceRepository $maintenanceRepository,
        BackgroundRepository $backgroundRepository
    ) {
        $this->branchRepository = $branchRepository;
        $this->accountRepository = $accountRepository;
        $this->maintenanceRepository = $maintenanceRepository;
        $this->backgroundRepository = $backgroundRepository;
    }

    /**
     * Get all branches
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->branchRepository->getList();
    }

    /**
     * @param Branch $branch
     * @return array
     */
    public function getListNews(Branch $branch): array
    {
        return $branch->news()->get()->toArray();
    }

    /**
     * @param $data
     * @return mixed|null
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->branchRepository->store($data);
            $newRecord->backgrounds()->create($this->
            saveImagesToDisk(PositionBackground::TOP1, $data['images'][0]));
            $this->accountRepository->create([
                'branch_id' => $newRecord->id,
                'username' => $data['admin_id'],
                'password' => Hash::make($data['admin_password']),
                'role' => AccountRole::ADMIN,
                'name' => "Admin " . $data['name'],
            ]);
            $this->createManyMaintain($newRecord);
            DB::commit();
            return $newRecord;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param $position
     * @param UploadedFile $file
     * @param $record
     * @return array
     */
    public function saveImagesToDisk($position, UploadedFile $file): array
    {
        $path = Storage::disk()->put(IMAGES_PATH, $file);
        $fileName = explode("/", $path)[2];
        return [
            'file_name' => $fileName,
            'position' => $position,
            'role_background' => AccountRole::SUPER_ADMIN,
        ];
    }

    /**
     * @param Branch $branch
     * @return void
     */
    public function createManyMaintain(Branch $branch)
    {
        $branch->maintenances()->createMany([
            [
                'role' => MaintainRole::ADMIN,
                'maintain_status' => MaintainStatus::ACTIVE
            ],
            [
                'role' => MaintainRole::USER,
                'maintain_status' => MaintainStatus::ACTIVE
            ]
        ]);
    }

    /**
     * @param $data
     * @param Branch $branch
     * @return Branch|null
     */
    public function update($data, Branch $branch): ?Branch
    {
        DB::beginTransaction();
        try {
            $oldImages = $branch->backgrounds()->where('role_background',
                AccountRole::SUPER_ADMIN)->first();
            $branch->update($data);
            Storage::disk()->delete(IMAGES_PATH . '/' . $oldImages['file_name']);
            $oldImages->update($this->saveImagesToDisk(PositionBackground::TOP1, $data['images'][0]));
            $branch->getAdmin()->update([
                'username' => $data['admin_id'],
                'password' => Hash::make($data['admin_password']),
            ]);
            DB::commit();
            return $branch;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param $data
     * @param $branch
     * @return void
     */
    public function updateImage($data, $branch)
    {
        if (isset($data['images']) && is_string($data['images'][0])) {
            return;
        }
        $this->deleteImages($branch);
        if (isset($data['images'])) {
            $branch->images()->createMany($this->storeImages($data));
        }
    }

    /**
     * @param Branch $branch
     * @return Branch|null
     */
    public function delete(Branch $branch): ?Branch
    {
        DB::beginTransaction();
        try {
            $branch->delete();
            $this->deleteImages($branch);
            DB::commit();
            return $branch;
        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return null;
        }
    }

    /**
     * @return Builder[]|Collection
     */
    public function getMaintain()
    {
        return $this->branchRepository->getMaintain();
    }

    /**
     * @param $data
     * @param Branch $branch
     * @return int
     */
    public function setMaintainBranch($data, Branch $branch): int
    {
        return $branch->maintenances()->where('role', $data['role'])
            ->update($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function setMaintain($data)
    {
        $branchIds = $data['branch_ids'];
        unset($data['branch_ids']);
        return $this->maintenanceRepository->setMaintain($branchIds, $data);
    }
}
