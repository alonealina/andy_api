<?php

namespace App\Services;

use App\Models\SystemInformation;
use App\Repositories\SystemInformationRepository;
use Illuminate\Support\Facades\Auth;

class SystemInformationService
{
    /**
     * @var SystemInformationRepository
     */
    protected $systemInformationRepository;

    /**
     * @param SystemInformationRepository $systemInformationRepository
     */
    public function __construct(SystemInformationRepository $systemInformationRepository)
    {
        $this->systemInformationRepository = $systemInformationRepository;
    }

    /**
     * @return mixed
     */
    public function getSystemInformation()
    {
        return Auth::user()->store->systemInformation->toArray();
    }

    /**
     * @param $data
     * @param SystemInformation $systemInformation
     * @return SystemInformation
     */
    public function update($data, SystemInformation $systemInformation): SystemInformation
    {
        $systemInformation->update($data);
        return $systemInformation;
    }
}
