<?php

namespace App\Domain\Services;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\VendorRepositoryInterface;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private VendorRepositoryInterface $vendorRepository
    ) {
    }

    public function store(array $data, int $vendorId): Product
    {
        $data['vendor_id'] = $vendorId;
        return $this->productRepository->store($data);
    }

    public function getProduct(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        return $this->productRepository->getProduct($perPage, $offset);
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->getProductById($id);
    }

    public function getProductByVendorId(int $vendorId): array
    {
        return $this->productRepository->getProductByVendorId($vendorId);
    }

    public function update(int $productId, array $data, int $userId): Product
    {
        $product = $this->productRepository->getProductById($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        if ($product->vendor->user_id !== $userId) {
            throw new \Exception('Unauthorized to update this product');
        }

        return $this->productRepository->update($productId, $data);
    }
    
    public function delete(int $productId, int $userId): bool
    {
        $product = $this->productRepository->getProductById($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        if ($product->vendor->user_id !== $userId) {
            throw new \Exception('Unauthorized to delete this product');
        }

        return $this->productRepository->delete($productId);
    }
}