<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Respuesta JSON estándar para éxito.
     */
    protected function successResponse($data, $message = 'Operación exitosa', $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Respuesta JSON estándar para errores.
     */
    protected function errorResponse($message, $code = 400)
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
