<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'phone' => $user->phone,
            'nationalCode' => $user->national_code,
            'gender' => $user->gender,
            'birthday' => $user->birthday_shamsi,
            'expertiseId' => $this->expertise_id,
            'dateStartTreatment' => $this->date_start_treatment_shamsi,
            'address' => $this->address,
            'clinicPhone' => $this->clinic_phone,
            'latitude' => $this->latitude,
            'longitude' => $this->latitude,
            'isActive' => $this->is_active,
            'createdAt' => $this->created_at_shamsi,
            'updatedAt' => $this->updated_at_shamsi,
            'expertise' => new ExpertiseResource($this->expertise),
            'doctorSchedules' => DoctorScheduleResource::collection($this->reviews),
            'reviews' => ReviewResource::collection($this->reviews),
            'rateAvrage' => number_format(Review::where('doctor_id', $this->id)->avg('rate'), 1, '.', '')
        ];
    }
}
