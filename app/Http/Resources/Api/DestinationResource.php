<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'image'       => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,

            'state' => [
                'id'   => $this->state?->id,
                'name' => $this->state?->name,
            ],

            'arrival_point' => [
                'id'   => $this->arrivalPoint?->id,
                'name' => $this->arrivalPoint?->name,
            ],

            'categories' => $this->categories->map(fn ($category) => [
                'id'   => $category->id,
                'name' => $category->name,
                'icon' => $category->icon,
            ]),
        ];
    }
}
