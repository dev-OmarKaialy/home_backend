<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' =>  new CategoryResource($this->whenLoaded('category') ),
            'description' => $this->description,
            'image_url' => $this->getFirstMediaUrl('services'),
            'serviceProviders' => ServiceProviderResource::collection($this->whenLoaded('serviceProviders') ),

        ];
    }
}
