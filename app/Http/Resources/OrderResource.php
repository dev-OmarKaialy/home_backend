<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'notes'=>$this->notes,
            'status'=>$this->status,
            'payment_status'=>$this->payment_status,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'username' => $this->user->username,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'service_date'=>$this->when($this->service_provider_id != NULL ,$this->service_date),
            'image_url' => $this->user->getFirstMediaUrl('customers') ?: null,
            'house' => $this->when($this->house_id != NULL ,new HouseResource($this->whenLoaded('house'))),
            'serviceProviders' => $this->when($this->service_provider_id != NULL ,new ServiceProviderResource($this->whenLoaded('serviceProviders'))),
            'address' => $this->when($this->service_provider_id != NULL ,new AddressResource($this->whenLoaded('address'))),
            'created_at' => $this->created_at->format('Y-m-d'), // تنسيق التاريخ والوقت

        ];
    }


}
