<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'doctorId' => $this->doctor_id,
            'dayOfWeek' => $this->day_of_week,
            'scheduleData' => $this->schedule_date_shamsi,
            'startTime' => $this->start_time_shamsi,
            'endTime' => $this->end_time_shamsi,
            'appointmentDuration' => $this->appointment_duration,
            'cost' => $this->cost,
            'createdAt' => $this->created_at_shamsi,
            'updatedAt' => $this->updated_at_shamsi,
        ];
    }
}
