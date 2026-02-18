<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PackageResource;
use App\Http\Resources\Api\PackageDetailResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * List packages with filters
     */
    public function index(Request $request)
    {
        $query = Package::query()
            ->where('status', true)
            ->with([
                'destinations:id,name,image',
                'categories:id,name,icon',
                'arrivalPoints:id,name',
            ]);

        if ($request->boolean('latest')) {
            $query->latest();
        }

        // Filters
        if ($request->filled('destination_id')) {
            $query->whereHas('destinations', fn ($q) =>
                $q->where('destinations.id', $request->destination_id)
            );
        }

        if ($request->filled('category_ids')) {

            $categoryIds = explode(',', $request->category_ids);

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('destination_categories.id', $categoryIds);
            });
        }

        if ($request->filled('arrival_point_id')) {
            $query->whereHas('arrivalPoints', fn ($q) =>
                $q->where('arrival_points.id', $request->arrival_point_id)
            );
        }

        // Include day plans if requested
        if ($request->boolean('with_day_plans')) {
            $query->with([
                'dayPlans' => function ($q) {
                    $q->orderBy('day_number')
                    ->with([
                        'destination:id,name,image',
                        'activities:id,name'
                    ]);
                }
            ]);
        }

        return PackageResource::collection(
            $query->orderBy('name')->paginate(10)
        );
    }

    /**
     * Package detail (always with day plans)
     */
    public function show(Package $package)
    {
        $package->load([
            'destinations:id,name,image',
            'categories:id,name,icon',
            'arrivalPoints:id,name',
            'dayPlans.destination:id,name,image',
            'dayPlans.activities:id,name',
        ]);

        return new PackageDetailResource($package);
    }
}
