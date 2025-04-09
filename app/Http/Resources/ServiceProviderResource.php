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
            'id' => $this->id,
            'hourly_rate' => $this->hourly_rate,


                'id' => $this->service->id,
                'service' => $this->service->name,
                'category' => $this->service->category->name ?? null,



                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'image_url' => $this->user->getFirstMediaUrl('service providers') ?: null,
                'address' => new AddressResource($this->user->address),

        ];
    }
}
