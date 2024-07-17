<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phone' => $this->phone,
            'nationalCode' => $this->national_code,
            'gender' => $this->gender == 0 ? 'مرد' : 'زن',
            'birthday' => $this->birthday,
            'code' => $this->code,
            'status' => $this->status == 1 ? 'active' : 'inactive',
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
