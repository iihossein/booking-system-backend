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
            'id' => $this->id,
            'userId' => $this->user_id,
            'expertiseId' => $this->expertise_id,
            'dateStartTreatment' => $this->date_start_treatment,
            'isActive' => $this->is_active,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            // اطلاعات کاربر از جدول users
            'user' => new UserResource($this->user),
            // اطلاعات تخصص از جدول expertise
            'expertise' => new ExpertiseResource($this->expertise),
        ];
    }
}
