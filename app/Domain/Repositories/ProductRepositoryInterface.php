<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function store(array $data): Product;
    public function getProduct(int $limit = 10, int $offset = 0): array;
    public function getProductById(int $id): ?Product;
    public function getProductByVendorId(int $vendorId): array;
    public function update(int $id, array $data): Product;
    public function delete(int $id): bool;
}