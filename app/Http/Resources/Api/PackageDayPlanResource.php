<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageDayPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'day' => $this->day_number,
            'destination' => $this->destination ? [
            'id' => $this->destination->id,
            'name' => $this->destination->name,
            'image' => $this->destination->image
                ? asset('storage/' . $this->destination->image)
                : null,
        ] : null,
            'description' => $this->description,
            'activities' => $this->activities->map(fn ($a) => [
                'id' => $a->id,
                'name' => $a->name,
            ]),
        ];
    }
}
