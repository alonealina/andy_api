<?php

namespace App\Repositories;

use App\Enums\SystemInformationBase;
use App\Models\Branch;
use App\Models\SystemInformation;

class SystemInformationRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
       return SystemInformation::class;
    }

    /**
     * @return mixed
     */
    public function getSystemInformation()
    {
        return $this->model->belongsToBranch()->first();
    }


    /**
     * @param Branch $branch
     * @return void
     */
    public function createSystemInformation(Branch $branch)
    {
        $branch->systeminformation()->create([
            'pm_last' => [
                'price' => SystemInformationBase::SYS_BASE,
                'minute' => SystemInformationBase::SYS_BASE,
            ],
            'companion_fee' => [
                'price' => SystemInformationBase::SYS_BASE
            ],
            'nomination_fee' => [
                'price' => SystemInformationBase::SYS_BASE
            ],
            'extension_fee' => [
                'first' => [
                    'price' => SystemInformationBase::SYS_BASE,
                    'minute' => SystemInformationBase::SYS_BASE
                ],
                'second' => [
                    'price' => SystemInformationBase::SYS_BASE,
                    'minute' => SystemInformationBase::SYS_BASE
                ]
            ],
            'vip_fee' => [
                'price' => SystemInformationBase::SYS_BASE,
                'set' => SystemInformationBase::SYS_BASE
            ],
            'shochu_fee' => [
                'price' => SystemInformationBase::SYS_BASE,
                'set' => SystemInformationBase::SYS_BASE,
                'people' => SystemInformationBase::SYS_BASE,
            ],
            'brandy_fee' => [
                'price' => SystemInformationBase::SYS_BASE,
                'set' => SystemInformationBase::SYS_BASE,
                'people' => SystemInformationBase::SYS_BASE,
            ],
            'whisky_fee' => [
                'price' => SystemInformationBase::SYS_BASE,
                'set' => SystemInformationBase::SYS_BASE,
                'people' => SystemInformationBase::SYS_BASE,
            ],
        ]);
    }
}
