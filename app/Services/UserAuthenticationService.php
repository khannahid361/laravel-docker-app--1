<?php

namespace App\Services;

use App\Repositories\Authentication\UserAuthenticationRepositoryInterface;

class UserAuthenticationService
{
    public function __construct(
        protected UserAuthenticationRepositoryInterface $authRepository
    ) {}

    public function register(array $data): array
    {
        $user = $this->authRepository->register($data);
        $token = $user->createToken('authToken')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        $user = $this->authRepository->login($credentials);

        if (!$user) {
            return null;
        }

        $token = $user->createToken('authToken')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
