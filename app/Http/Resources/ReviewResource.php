<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'doctorId' => $this->doctor_id,
            'text' => $this->text,
            'rate' => $this->rate,
            'isAccepted' => $this->is_accepted,
            'createdAt' => $this->created_at_shamsi,
            'updatedAt' => $this->updated_at_shamsi,
        ];
    }
}
