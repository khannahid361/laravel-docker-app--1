<?php

namespace App\Repositories\Authentication;

interface UserAuthenticationRepositoryInterface
{
    public function register(array $data);

    public function login(array $credentials);
}
