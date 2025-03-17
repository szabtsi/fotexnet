<?php

namespace App\Traits;

trait ApiResponder
{
    protected function success($data = [], $code = 200)
    {
        return response()->json(['data' => $data], $code);
    }

    protected function error($message, $code)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'code' => $code,
            ],
        ], $code);
    }
}
