<?php
namespace App\Traits;

trait HttpResponses
{
    protected function successResponse($step = null, $description, $message = null, $code = 200)
    {
        if ($step) {
            return response()->json(
                [
                    'status' => 'success',
                    'step' => $step,
                    'description' => $description,
                    'message' => $message
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
    protected function errorResponse($step = null, $description, $message = null, $code)
    {
        if ($step) {
            return response()->json(
                [
                    'status' => 'error',
                    'step' => $step,
                    'description' => $description,
                    'message' => $message
                ],
                $code
            );
        } else {
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
}
