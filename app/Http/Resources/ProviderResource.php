<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'hourly_rate' => $this->hourly_rate,
            'service_id' => $this->service_id,
            'profile_photo_url' => $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path) : null,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
