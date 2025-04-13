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
            'media_urls' => $this->getFirstMediaUrl('categories'),
            'services' => ServiceResource::collection($this->whenLoaded('services'))
        ];
    }


}
