<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\ExpertiseResource;
use App\Models\Doctor;
use App\Models\Expertise;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $doctors = Doctor::all();
        $expertises = Expertise::all();
        $best_doctors = Doctor::inRandomOrder()->limit(20)->get();
        return [
            'expertises' => ExpertiseResource::collection($expertises),
            'doctors' => DoctorResource::collection($doctors),
            'bestDoctors' => DoctorResource::collection($best_doctors)
        ];
    }
    /**
     * @OA\Get(
     *   path="/api/search",
     *   summary="Search for doctors by name",
     *   tags={"Doctors"},
     *   @OA\Parameter(
     *       name="name",
     *       in="query",
     *       description="Doctor name",
     *       required=true,
     *       @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Successful search",
     *       
     *   )
     * )
     */
    public function search(SearchRequest $request)
    {
        $name = $request->get('name');
        $doctors = Doctor::searchByName($name)->get();
        return DoctorResource::collection($doctors);
    }





}
