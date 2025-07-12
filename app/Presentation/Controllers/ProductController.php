<?php

namespace App\Presentation\Controllers;

use App\Domain\Services\VendorService;
use App\Helpers\ResponseFormatterHelper;
use App\Http\Controllers\Controller;
use App\Domain\Services\ProductService;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Presentation\Requests\ProductRequest;
use App\Presentation\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private ProductRepositoryInterface $productRepository,
        private VendorService $vendorService
    ) {
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $vendor = auth()->user()->vendor;

            if (!$vendor) {
                return ResponseFormatterHelper::error(
                    'Vendor not found',
                    404,
                    'You must register as a vendor before adding products.'
                );
            }

            $product = $this->productService->store(
                $request->validated(),
                $vendor->id
            );

            return ResponseFormatterHelper::success(
                new ProductResource($product),
                'Product created successfully',
                201
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Product creation failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function getProduct(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);

            $page = max(1, $page);
            $perPage = min(100, max(1, $perPage));

            $product = $this->productService->getProduct($page, $perPage);

            return ResponseFormatterHelper::success(
                $product['data'],
                'Product retrieved successfully',
                200,
                [
                    'total' => $product['total'],
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'last_page' => ceil($product['total'] / $perPage),
                    'has_more' => $product['has_more']
                ]
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Failed to retrieve product',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function getProductById(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);

            if (!$product) {
                return ResponseFormatterHelper::error(
                    'Product not found',
                    404,
                    'The product you are looking for does not exist.'
                );
            }

            return ResponseFormatterHelper::success(
                new ProductResource($product),
                'Product retrieved successfully',
                200
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Failed to retrieve product',
                $err->getCode() ?: 404,
                $err->getMessage()
            );
        }
    }

    public function getProductByVendorId(int $vendorId): JsonResponse
    {
        try {
            $products = $this->productService->getProductByVendorId($vendorId);

            if (!$products) {
                return ResponseFormatterHelper::error(
                    'No products found for this vendor',
                    404,
                    'The vendor has no products registered.'
                );
            }

            return ResponseFormatterHelper::success(
                $products,
                'Products retrieved successfully',
                200
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Failed to retrieve vendor products',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $product = $this->productService->update(
                $id,
                $request->all(),
                auth()->id()
            );

            return ResponseFormatterHelper::success(
                new ProductResource($product),
                'Product updated successfully',
                200
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Product update failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->productService->delete($id, auth()->id());

            return ResponseFormatterHelper::success(
                [],
                'Product deleted successfully',
                200
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Product deletion failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }
}