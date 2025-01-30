<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function success($message, $data = [], $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
        
        error_log(json_encode($response, JSON_PRETTY_PRINT));

        return response()->json($response, $statusCode);
    }

    public static function error($message, $errors = [], $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
        
        error_log(json_encode($response, JSON_PRETTY_PRINT));

        return response()->json($response, $statusCode);
    }
}
