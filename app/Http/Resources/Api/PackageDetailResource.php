<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'description'    => $this->description,
            'number_of_days' => $this->number_of_days,
            'base_price'     => $this->base_price,

            'images' => [
                'package' => $this->package_image
                    ? asset('storage/' . $this->package_image)
                    : null,
                'route_map' => $this->route_map_image
                    ? asset('storage/' . $this->route_map_image)
                    : null,
            ],

            'destinations' => $this->destinations->map(fn ($d) => [
                'id' => $d->id,
                'name' => $d->name,
            ]),

            'categories' => $this->categories->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'icon' => $c->icon,
            ]),

            'arrival_points' => $this->arrivalPoints->map(fn ($a) => [
                'id' => $a->id,
                'name' => $a->name,
            ]),

            'day_plans' => PackageDayPlanResource::collection($this->dayPlans),
        ];
    }
}
