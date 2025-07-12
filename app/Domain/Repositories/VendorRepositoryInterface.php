<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Vendor;
use Illuminate\Pagination\LengthAwarePaginator;

interface VendorRepositoryInterface
{
    public function store(array $data): Vendor;
    public function getVendor(int $limit = 10, int $offset = 0): array;
    public function getVendorByUserId(int $userId): ?Vendor;
}