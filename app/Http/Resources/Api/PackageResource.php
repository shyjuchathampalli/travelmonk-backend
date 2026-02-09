<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'description'    => $this->description,
            'number_of_days' => $this->number_of_days,
            'base_price'     => $this->base_price,

            'package_image' => $this->package_image
                ? asset('storage/' . $this->package_image)
                : null,

            'route_map_image' => $this->route_map_image
                ? asset('storage/' . $this->route_map_image)
                : null,

            'destinations' => $this->destinations->pluck('name'),
            'categories'   => $this->categories->pluck('name'),
            'arrival_points' => $this->arrivalPoints->pluck('name'),

            // Only included if eager-loaded
            'day_plans' => $this->whenLoaded('dayPlans', function () {
                return PackageDayPlanResource::collection($this->dayPlans);
            }),
        ];
    }
}
