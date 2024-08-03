<?php

namespace App\Http\Resources;

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
        return [
            'doctor' => [
                'id' => $this->id,
                'userId' => $this->user_id,
                'expertiseId' => $this->expertise_id,
                'dateStartTreatment' => $this->date_start_treatment,
                'isActive' => $this->is_active,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'user' => new UserResource($this->user),
            'expertise' => new ExpertiseResource($this->expertise),
            'office' => new OfficeResource($this->office),
            'review' => new ReviewResource($this->review),
        ];
    }
}
