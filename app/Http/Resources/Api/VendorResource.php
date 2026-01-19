<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'business_name' => $this->business_name,
            'caption'       => $this->caption,
            'details'       => $this->details,
            'price_range'   => $this->price_range,

            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'contact' => [
                'name'  => $this->contact_name,
                'email' => $this->email,
                'phone' => $this->phone,
            ],

            'destination' => [
                'id'   => $this->destination?->id,
                'name' => $this->destination?->name,
            ],

            'category' => [
                'id'   => $this->destinationCategory?->id,
                'name' => $this->destinationCategory?->name,
            ],
        ];
    }
}
