<?php

namespace App\Presentation\Controllers;

use App\Helpers\ResponseFormatterHelper;
use App\Http\Controllers\Controller;
use App\Domain\Services\AuthService;
use App\Presentation\Requests\RegisterRequest;
use App\Presentation\Requests\LoginRequest;
use App\Presentation\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());

            return ResponseFormatterHelper::success(
                new UserResource($user),
                'User registered successfully',
                201
            );
        } catch (\Exception $err) {

            return ResponseFormatterHelper::error(
                'Registration failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return ResponseFormatterHelper::success(
                $result,
                'Login successful',
                200
            );
        } catch (\Exception $err) {
            return ResponseFormatterHelper::error(
                'Login failed',
                $err->getCode() ?: 401,
                $err->getMessage()
            );
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();

            return ResponseFormatterHelper::success(
                null,
                'Logged out successfully',
                200
            );
        } catch (\Exception $err) {
            return ResponseFormatterHelper::error(
                'Logout failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            $token = $this->authService->refresh();

            return ResponseFormatterHelper::success(
                [
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ],
                'Token refreshed successfully',
                200
            );
        } catch (\Exception $err) {
            return ResponseFormatterHelper::error(
                'Token refresh failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function profile(): JsonResponse
    {
        try {
            return ResponseFormatterHelper::success(
                new UserResource(auth()->user()),
                'User profile retrieved successfully',
                200
            );
        } catch (\Exception $err) {
            return ResponseFormatterHelper::error(
                'Failed to retrieve user profile',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }
}