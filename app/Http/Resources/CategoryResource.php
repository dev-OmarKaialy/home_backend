<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            'services' => $this->whenLoaded('services') , // Include services
            'media' => $this->whenLoaded('media'),
        ];
    }

}
