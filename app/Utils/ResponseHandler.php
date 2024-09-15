<?php

namespace App\Utils;

use Illuminate\Http\Response;

class ResponseHandler
{
    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    /**
     * @param int $code
     * @param string $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($code = 400, $message = 'Error',  $data = null)
    {
        $statusCode = $code == 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $code;
        if ($statusCode > Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'An unexpected error occurred';
        }

        if (is_string($statusCode)) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json([
            'code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
