<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hourly_rate' => $this->hourly_rate,

            'user_id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'works' => $this->getMedia('works')->pluck('original_url'),
            'image'    => $this->getFirstMediaUrl('service providers') ?: null,
            'address' => new AddressResource($this->address),

        ];
    }
}
