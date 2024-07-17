<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\WhoamiResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/whoami",
     *     tags={"Users"},
     *     summary="Get Current User",
     *     description="Retrieve the current user",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="string",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="firstName",
     *                 type="string",
     *                 example="John"
     *             ),
     *             @OA\Property(
     *                 property="lastName",
     *                 type="string",
     *                 example="Doe"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 example="0123456789"
     *             ),
     *             @OA\Property(
     *                 property="nationalCode",
     *                 type="string",
     *                 example="1234567890"
     *             ),
     *             @OA\Property(
     *                 property="gender",
     *                 type="string",
     *                 example="مرد"
     *             ),
     *             @OA\Property(
     *                 property="birthday",
     *                 type="string",
     *                 example="1990-01-01"
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string",
     *                 example="123456"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="active"
     *             ),
     *             @OA\Property(
     *                 property="createdAt",
     *                 type="string",
     *                 example="2022-01-01 00:00:00"
     *             ),
     *             @OA\Property(
     *                 property="updatedAt",
     *                 type="string",
     *                 example="2022-01-01 00:00:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function whoami()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
