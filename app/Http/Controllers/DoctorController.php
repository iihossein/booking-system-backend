<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/doctors",
     *     tags={"Doctors"},
     *     summary="Get All Doctors",
     *     description="Retrieve all doctors",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="doctor_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="specialization_id_fk",
     *                     type="integer",
     *                     example=12
     *                 ),
     *                 @OA\Property(
     *                     property="doctor_rooms",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="doctor_room_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="room",
     *                             type="string",
     *                             example="151"
     *                         ),
     *                         @OA\Property(
     *                             property="doctor_id_fk",
     *                             type="integer",
     *                             example=1
     *                         )
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
    public function index()
    {
        $doctors = Doctor::all();
        return DoctorResource::collection($doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/doctors/{id}",
     *     tags={"Doctors"},
     *     summary="Get Doctor by ID",
     *     description="Retrieve a doctor by its ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Doctor ID",
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
     *                 property="doctor",
     *                 type="object",
     *                 @OA\Property(
     *                     property="doctor_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="specialization_id_fk",
     *                     type="integer",
     *                     example=12
     *                 ),
     *                 @OA\Property(
     *                     property="doctor_rooms",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="doctor_room_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="room",
     *                             type="string",
     *                             example="151"
     *                         ),
     *                         @OA\Property(
     *                             property="doctor_id_fk",
     *                             type="integer",
     *                             example=1
     *                         )
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
        $doctor = Doctor::findOrFail($id);
        return new DoctorResource($doctor);
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
     *     path="/api/doctors/{id}",
     *     tags={"Doctors"},
     *     summary="Delete Doctor by ID",
     *     description="Delete a doctor by its ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Doctor ID",
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
     *                 example="دکتر مورد نظر با موفقیت حذف شد."
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
        $doctor = Doctor::findOrFail($id);
        $doctor->destroy($id);
        return json_encode([
            'messages' => 'دکتر مورد نظر با موفقیت حذف شد.'
        ]);
    }
}
