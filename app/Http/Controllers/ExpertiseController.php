<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpertiseResource;
use App\Models\Expertise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExpertiseController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/expertise",
     *     tags={"Expertises"},
     *     summary="Get all expertises",
     *     description="Get all expertises",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         
     *     )
     * )
     */
    public function index()
    {
        $expertises = Expertise::all();
        return ExpertiseResource::collection($expertises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/expertise/{id}",
     *     tags={"Expertises"},
     *     summary="Get Expertise by ID",
     *     description="Retrieve an expertise by its ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Expertise ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="expertise",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Expertise Name"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $expertise = Expertise::findOrFail($id);
        return new ExpertiseResource($expertise);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/expertise/{id}",
     *     tags={"Expertises"},
     *     summary="Delete Expertise by ID",
     *     description="Delete an expertise by its ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Expertise ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="messages",
     *                 type="string",
     *                 example="تخصص مورد نظر با موفقیت حذف شد."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $expertise = Expertise::findOrFail($id);
        $expertise->destroy($id);

        return json_encode([
            'messages' => 'تخصص مورد نظر با موفقیت حذف شد.'
        ]);
    }
}
