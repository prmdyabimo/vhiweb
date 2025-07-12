<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use Exception;
use Log;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function register(array $data): User
    {
        try {
            return User::create($data);
        } catch (Exception $err) {
            Log::error('Failed to register user', [
                'error' => $err->getMessage(),
            ]);

            throw new \RuntimeException('Failed to register user: ' . $err->getMessage(), 500);
        }
    }
}