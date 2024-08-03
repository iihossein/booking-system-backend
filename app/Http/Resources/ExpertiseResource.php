<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpertiseResource extends JsonResource
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
            'name' => $this->name,
            // 'slug' => $this->slug,
            // 'image' => $this->hasMedia('image') ? $this->getFirstMediaUrl('image') : null,
            // 'image' => $this->getFirstMedia('image')->first()->getFullUrl(),
            // {{ asset( $ex->getFirstMediaUrl('image'))  }}
        ];
    }
}
