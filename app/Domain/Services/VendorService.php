<?php

namespace App\Domain\Services;

use App\Domain\Entities\Vendor;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\VendorRepositoryInterface;

class VendorService
{
    public function __construct(
        private VendorRepositoryInterface $vendorRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function store(array $data, int $userId): Vendor
    {
        $data['user_id'] = $userId;
        return $this->vendorRepository->store($data);
    }

    public function getVendor(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        return $this->vendorRepository->getVendor($perPage, $offset);
    }

    public function getVendorByUserId(int $userId): ?Vendor
    {
        return $this->vendorRepository->getVendorByUserId($userId);
    }
}