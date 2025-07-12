<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Vendor;
use App\Domain\Repositories\VendorRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class EloquentVendorRepository implements VendorRepositoryInterface
{
    public function store(array $data): Vendor
    {
        try {
            return Vendor::create($data);
        } catch (Exception $err) {
            Log::error('Failed to store vendor', [
                'error' => $err->getMessage(),
            ]);

            throw new \RuntimeException('Failed to store vendor: ' . $err->getMessage(), 500);
        }
    }

    public function getVendor(int $limit = 10, int $offset = 0): array
    {
        try {
            $query = Vendor::query()
                ->orderBy('created_at', 'desc');

            $total = $query->count();

            $vendors = $query
                ->take($limit)
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->map(function ($vendor) {
                    return [
                        'id' => $vendor->id,
                        'user_id' => $vendor->user_id,
                        'company_name' => $vendor->company_name,
                        'company_address' => $vendor->company_address,
                        'company_phone' => $vendor->company_phone,
                        'company_email' => $vendor->company_email,
                        'tax_number' => $vendor->tax_number,
                        'business_license' => $vendor->business_license,
                        'status' => $vendor->status,
                        'description' => $vendor->description,
                        'is_active' => $vendor->is_active,
                        'created_at' => $vendor->created_at,
                        'updated_at' => $vendor->updated_at,
                    ];
                })
                ->toArray();

            return [
                'data' => $vendors,
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset,
                'has_more' => ($offset + $limit) < $total,
            ];
        } catch (Exception $err) {
            Log::error('Failed to get vendor', [
                'error' => $err->getMessage(),
            ]);

            return [];
        }
    }

    public function getVendorByUserId(int $userId): ?Vendor
    {
        try {
            $vendor = Vendor::where('user_id', $userId)->first();

            return $vendor;
        } catch (Exception $err) {
            Log::error('Failed to get vendor by user ID', [
                'error'->$err->getMessage()
            ]);

            return null;
        }
    }
}