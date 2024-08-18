<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'doctorId' => $this->doctor_id,
            'userId' => $this->user_id,
            'doctorScheduleId' => $this->doctor_schedule_id,
            'appointmentDateTime' => $this->appointment_date_time_shamsi,
            'status' => $this->status,
            'createdAt' => $this->created_at_shamsi,
            'updatedAt' => $this->updated_at_shamsi,
        ];
    }
}
