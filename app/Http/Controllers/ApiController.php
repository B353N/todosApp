<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Return error response.
     *
     * @param string|array $message
     * @param string $code
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError(array|string $message, string $code, int $statusCode)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'status_code' => $code,
            ],
        ], $statusCode);
    }
}
