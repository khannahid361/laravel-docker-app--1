<?php

namespace App\Repositories\Authentication;

use App\Models\User;

interface UserAuthenticationRepositoryInterface
{
    public function register(array $data): User;

    public function login(array $credentials);
}
