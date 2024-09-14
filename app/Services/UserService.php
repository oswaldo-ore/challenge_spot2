<?php

namespace App\Services;

use App\Repositories\UserRepository;


class UserService
{
    protected UserRepository $userRepository;

    public function __constructor(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }
}
