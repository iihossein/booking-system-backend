<?php
namespace App\Traits;

trait HttpResponses
{
    protected function successResponse($description, $message = null, $token = null, $code = 200)
    {
        if ($token) {
            return response()->json(
                [
                    'status' => 'success',
                    'description' => $description,
                    'message' => $message,
                    'token' => $token
                ],
                $code
            );
        } else {
            return response()->json(
                [
                    'status' => 'success',
                    'description' => $description,
                    'message' => $message
                ],
                $code
            );
        }

    }
    protected function errorResponse($description, $message = null, $code)
    {
        return response()->json(
            [
                'status' => 'error',
                'description' => $description,
                'message' => $message
            ],
            $code
        );
    }
}
