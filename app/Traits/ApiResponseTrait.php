<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Generate a success response.
     *
     * @param  mixed|null  $data  The data to include in the response.
     * @param  int  $statusCode  The HTTP status code (default is 200).
     */
    public function success(mixed $data = null, int $statusCode = 200): JsonResponse
    {
        $responseArr = $this->apiResponse($statusCode, 'OK', $data);

        return response()->json($responseArr, $statusCode);
    }

    /**
     * Generate a success response for resource creation.
     *
     * @param  mixed|null  $data  The data to include in the response.
     * @param  int  $statusCode  The HTTP status code (default is 201).
     */
    public function successStore(mixed $data = null, int $statusCode = 201): JsonResponse
    {
        return $this->success($data, $statusCode);
    }

    /**
     * Generate a success response for resource update.
     *
     * @param  mixed|null  $data  The data to include in the response.
     * @param  int  $statusCode  The HTTP status code (default is 200).
     */
    public function successUpdate(mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return $this->success($data, $statusCode);
    }

    /**
     * Generate a success response for resource deletion.
     *
     * @param  mixed|null  $data  The data to include in the response (optional).
     * @param  int  $statusCode  The HTTP status code (default is 204).
     */
    public function successDelete(mixed $data = null, int $statusCode = 204): JsonResponse
    {
        return $this->success($data, $statusCode);
    }

    /**
     * Generate an error response.
     *
     * @param  string  $detail  The error message.
     * @param  int  $statusCode  The HTTP status code (default is 500).
     */
    public function error(string $detail = '', int $statusCode = 500): JsonResponse
    {
        // Ensure the status code is within the valid HTTP range
        if ($statusCode < 200 || $statusCode > 599) {
            $statusCode = 500;
        }

        $errorApiResponse = $this->apiResponse($statusCode, $detail);

        return response()->json($errorApiResponse, $statusCode);
    }

    /**
     * Create a standardized API response format.
     *
     * @param  int|null  $status  The HTTP status code.
     * @param  string|null  $message  A message associated with the response.
     * @param  mixed|null  $data  The data to include in the response.
     */
    public function apiResponse(?int $status = null, ?string $message = null, mixed $data = null): array
    {
        return [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'success' => $status >= 200 && $status < 300,
            'data' => $data,
            'error' => $status >= 400 && $status < 600,
            'status' => $status,
            'message' => $message,
        ];
    }
}
