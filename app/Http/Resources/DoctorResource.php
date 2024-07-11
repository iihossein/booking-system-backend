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
            'user_id' => $this->user_id,
            'expertise_id' => $this->expertise_id,
            'date_start_treatment' => $this->date_start_treatment,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // اطلاعات کاربر از جدول users
            'user' => new UserResource($this->user),
            // اطلاعات تخصص از جدول expertise
            'expertise' => new ExpertiseResource($this->expertise),
        ];
    }
}
