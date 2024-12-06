<?php

namespace App\Controllers\Traits;

trait ApiResponseTrait
{
    /**
     * Format Response Message
     */
    public function formatResponse(
        array $data = [],
        string $message = 'ok',
        string $code = 'SUCCESS',
        int $status_code = 200
    ) {
        $status = compact('code', '');

        return response()->json(compact('data', 'status'), 200);
    }

    /**
     * Format Success Response
     */
    public function formatSuccessResponse(
        array $data = [],
        string $message = 'ok',
        string $code = 'SUCCESS'
    ) {
        return $this->formatResponse($data, $message, $code, 200);
    }

    /**
     * Format Error Response
     */
    public function formatErrorResponse(
        array $data = [],
        string $message = 'Internal Server Error',
        string $code = 'INTERNAL_SERVER_ERROR'
    ) {
        return $this->formatResponse($data, $message, $code, 500);
    }
}
