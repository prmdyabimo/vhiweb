<?php

namespace App\Helpers;

class ResponseFormatterHelper
{
    /**
     * Default response structure
     */
    protected static $response = [
        "meta" => [
            "code" => 200,
            "status" => "success",
            "message" => null,
        ],
        "data" => null,
    ];

    /**
     * Success response with pagination
     */
    public static function success($data = null, $message = null, $code = 200, $pagination = null)
    {
        $response = self::$response;
        $response['meta']['code'] = $code;
        $response['meta']['status'] = 'success';
        $response['meta']['message'] = $message;
        $response['data'] = $data;

        if ($pagination) {
            $response['pagination'] = $pagination;
        }

        return response()->json($response, $code);
    }

    /**
     * Error response
     */
    public static function error($message = 'Error', $code = 500, $errors = null)
    {
        $response = self::$response;
        $response['meta']['code'] = $code;
        $response['meta']['status'] = 'error';
        $response['meta']['message'] = $message;
        $response['data'] = null;

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Create pagination metadata
     */
    public static function createPagination($paginator)
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'has_more_pages' => $paginator->hasMorePages(),
            'next_page_url' => $paginator->nextPageUrl(),
            'prev_page_url' => $paginator->previousPageUrl()
        ];
    }
}