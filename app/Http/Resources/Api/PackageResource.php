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
            'slug'           => $this->slug,
            'description'    => $this->description,
            'number_of_days' => $this->number_of_days,
            'base_price'     => $this->base_price,

            'package_image' => $this->package_image
                ? asset('storage/' . $this->package_image)
                : null,

            'route_map_image' => $this->route_map_image
                ? asset('storage/' . $this->route_map_image)
                : null,

            // 🔥 FULL DESTINATION OBJECTS
            'destinations' => $this->whenLoaded('destinations', function () {
                return $this->destinations->map(function ($destination) {
                    return [
                        'id' => $destination->id,
                        'name' => $destination->name,
                        'image' => $destination->image
                            ? asset('storage/' . $destination->image)
                            : null,
                    ];
                });
            }),

            // 🔥 FULL CATEGORY OBJECTS
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'icon' => $category->icon,
                    ];
                });
            }),

            'arrival_points' => $this->whenLoaded('arrivalPoints', function () {
                return $this->arrivalPoints->map(function ($point) {
                    return [
                        'id' => $point->id,
                        'name' => $point->name,
                    ];
                });
            }),

            'day_plans' => $this->whenLoaded('dayPlans', function () {
                return PackageDayPlanResource::collection($this->dayPlans);
            }),
        ];
    }
}
