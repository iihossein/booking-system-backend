<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'national_code' => $this->national_code,
            'expertise_id' => $this->expertise_id,
            'code' => $this->code,
            'date_start_treatment' => $this->date_start_treatment,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
        ];
    }
}
