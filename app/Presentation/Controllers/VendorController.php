<?php

namespace App\Presentation\Controllers;

use App\Helpers\ResponseFormatterHelper;
use App\Http\Controllers\Controller;
use App\Domain\Services\VendorService;
use App\Presentation\Requests\VendorRegistrationRequest;
use App\Presentation\Resources\VendorResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct(
        private VendorService $vendorService
    ) {
    }

    public function store(VendorRegistrationRequest $request): JsonResponse
    {
        try {
            $existingVendorByUserId = $this->vendorService->getVendorByUserId(auth()->id());

            if ($existingVendorByUserId) {
                return ResponseFormatterHelper::error(
                    'Vendor by user id already registered',
                    400,
                    'You have already registered as a vendor.'
                );
            }

            $vendor = $this->vendorService->store(
                $request->validated(),
                auth()->id()
            );

            return ResponseFormatterHelper::success(
                new VendorResource($vendor),
                'Vendor registered successfully',
                201
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Vendor registration failed',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }

    public function getVendor(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);

            $page = max(1, $page);
            $perPage = min(100, max(1, $perPage));

            $vendor = $this->vendorService->getVendor($page, $perPage);

            return ResponseFormatterHelper::success(
                $vendor['data'],
                'Vendor retrieved successfully',
                200,
                [
                    'total' => $vendor['total'],
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'last_page' => ceil($vendor['total'] / $perPage),
                    'has_more' => $vendor['has_more']
                ]
            );
        } catch (Exception $err) {
            return ResponseFormatterHelper::error(
                'Failed to retrieve vendor',
                $err->getCode() ?: 400,
                $err->getMessage()
            );
        }
    }
}