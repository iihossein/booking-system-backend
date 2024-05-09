<?php

namespace App\Http\Controllers;

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
            'best_doctors' => DoctorResource::collection($best_doctors)
        ];
    }
}
