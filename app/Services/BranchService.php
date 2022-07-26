<?php

namespace App\Services;

use App\Enums\AccountRole;
use App\Models\Branch;
use App\Repositories\AccountRepository;
use App\Repositories\BranchRepository;
use App\Traits\SaveImagesUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
     * Construct function
     *
     * @param BranchRepository $branchRepository
     * @param AccountRepository $accountRepository
     */
    public function __construct(
        BranchRepository $branchRepository,
        AccountRepository $accountRepository
    ) {
        $this->branchRepository = $branchRepository;
        $this->accountRepository = $accountRepository;
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
     * @param $data
     * @return mixed|null
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $newRecord = $this->branchRepository->store($data);
            $newRecord->images()->createMany($this->storeImages($data));
            $this->accountRepository->create([
                'branch_id' => $newRecord->id,
                'username' => $data['admin_id'],
                'password' => Hash::make($data['admin_password']),
                'role' => AccountRole::ADMIN,
                'name' => "Admin " . $data['name'],
            ]);
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
     * @param Branch $branch
     * @return Branch|null
     */
    public function update($data, Branch $branch): ?Branch
    {
        DB::beginTransaction();
        try {
            $branch->update($data);
            $this->updateImage($data, $branch);
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
        if (isset($data['images']) && is_string($data['images'][0])) return;
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
}
