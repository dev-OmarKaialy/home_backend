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
    public function toArray(Request $request)
    {
        return
            ['id' => $this->id,
                'user_name' => $this->username,
                'full_name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'token' => $this->token,
                'image'    => $this->getFirstMediaUrl('customers') ?: null, // إذا ما فيه صورة يرجع null
                'address' => $this->address,
            ];
    }
}
