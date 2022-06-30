<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Construct function
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Collection|Model[]
     */
    public function getAll()
    {
        return $this->userRepository->getAll();
    }
}
