<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
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
     *         
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



}
