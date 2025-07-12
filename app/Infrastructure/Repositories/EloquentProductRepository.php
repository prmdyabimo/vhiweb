<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function store(array $data): Product
    {
        try {
            return Product::create($data);
        } catch (Exception $err) {
            Log::error('Failed to store product', [
                'error' => $err->getMessage(),
            ]);

            throw new \RuntimeException('Failed to store product: ' . $err->getMessage(), 500);
        }
    }

    public function getProduct(int $limit = 10, int $offset = 0): array
    {
        try {
            $query = Product::query()
                ->orderBy('created_at', 'desc');

            $total = $query->count();

            $products = $query
                ->take($limit)
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'vendor_id' => $product->vendor_id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'category' => $product->category,
                        'price' => $product->price,
                        'stock_quantity' => $product->stock_quantity,
                        'sku' => $product->sku,
                        'specifications' => $product->specifications,
                        'is_active' => $product->is_active,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ];
                })
                ->toArray();

            return [
                'data' => $products,
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset,
                'has_more' => ($offset + $limit) < $total,
            ];
        } catch (Exception $err) {
            Log::error('Failed to get product', [
                'error' => $err->getMessage(),
            ]);

            return [];
        }
    }

    public function getProductById(int $id): ?Product
    {
        try {
            return Product::find($id);
        } catch (Exception $err) {
            Log::error('Failed to find product by ID', [
                'error' => $err->getMessage(),
            ]);

            return null;
        }
    }

    public function getProductByVendorId(int $vendorId): array
    {
        try {
            return Product::where('vendor_id', $vendorId)->get()->toArray();
        } catch (Exception $err) {
            Log::error('Failed to find products by vendor ID', [
                'error' => $err->getMessage(),
            ]);

            return [];
        }
    }

    public function update(int $id, array $data): Product
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($data);

            return $product;
        } catch (Exception $err) {
            Log::error('Failed to update product', [
                'error' => $err->getMessage(),
            ]);

            throw new \RuntimeException('Failed to update product: ' . $err->getMessage(), 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $product = Product::findOrFail($id);
            return $product->delete();
        } catch (Exception $err) {
            Log::error('Failed to delete product', [
                'error' => $err->getMessage(),
            ]);

            throw new \RuntimeException('Failed to delete product: ' . $err->getMessage(), 500);
        }
    }
}