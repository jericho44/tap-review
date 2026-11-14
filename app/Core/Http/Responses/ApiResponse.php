<?php

namespace App\Core\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Build success response envelope (API-10).
     */
    public static function success(
        mixed $data = [],
        string $message = 'Success',
        int $statusCode = Response::HTTP_OK,
        array $extraMeta = []
    ): JsonResponse {
        $meta = array_merge([
            'request_id' => Request::header('X-Request-ID', (string) str()->uuid()),
            'timestamp' => Carbon::now('UTC')->toIso8601ZuluString(),
        ], $extraMeta);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $statusCode);
    }

    /**
     * Build paginated response envelope (PAG-07, PAG-08).
     */
    public static function paginated(
        LengthAwarePaginator $paginator,
        mixed $transformedData = null,
        string $message = 'Success'
    ): JsonResponse {
        $pagination = [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem() ?? 0,
            'to' => $paginator->lastItem() ?? 0,
            'has_next' => $paginator->hasMorePages(),
            'has_previous' => $paginator->currentPage() > 1,
        ];

        return self::success(
            data: $transformedData ?? $paginator->items(),
            message: $message,
            statusCode: Response::HTTP_OK,
            extraMeta: ['pagination' => $pagination]
        );
    }

    /**
     * Build error response envelope (API-20).
     */
    public static function error(
        string $message = 'Error',
        int $statusCode = Response::HTTP_BAD_REQUEST,
        ?array $errors = null,
        ?string $errorCode = null
    ): JsonResponse {
        $meta = [
            'request_id' => Request::header('X-Request-ID', (string) str()->uuid()),
            'timestamp' => Carbon::now('UTC')->toIso8601ZuluString(),
        ];

        $payload = [
            'success' => false,
            'message' => $message,
            'meta' => $meta,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        if ($errorCode !== null) {
            $payload['error_code'] = $errorCode;
        }

        return response()->json($payload, $statusCode);
    }
}
