<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function success($data = null, $messages = '', $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'messages' => $messages,
            'code' => $code
        ]);
    }

    public function error($messages = '', $code = 422): JsonResponse
    {
        return response()->json([
            'data' => null,
            'messages' => $messages,
            'code' => $code
        ]);
    }
}
