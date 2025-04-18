<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'price'        => $this->price,
            'status'       => $this->status,

            // Get image URL from media library (collection: 'service houses')
            'image'        => $this->getFirstMediaUrl('houses'),

            // Related address
            'address' => new AddressResource($this->whenLoaded('address')),
            'owner' => $this->whenLoaded('owner', function () {
                return [
                    'id' => $this->owner->id,
                    'name' => $this->owner->name,
                    'email' => $this->owner->email,
                    'image_url' => $this->owner->getFirstMediaUrl('customers'),
                    'phone' => $this->owner->phone
                ];
            }),
        ];
    }
}
