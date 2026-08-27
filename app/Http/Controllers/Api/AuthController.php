<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Repositories\Authentication\UserAuthenticationRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function __construct(
        private UserAuthenticationRepositoryInterface $authRepository
    ) {}

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->authRepository->register($data);
        
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->authRepository->login($credentials);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data' => null,
            ], 401);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }
}
