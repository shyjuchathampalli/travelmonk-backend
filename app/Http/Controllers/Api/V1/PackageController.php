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
                'destinations:id,name',
                'categories:id,name,icon',
                'arrivalPoints:id,name',
            ]);

        // Filters
        if ($request->filled('destination_id')) {
            $query->whereHas('destinations', fn ($q) =>
                $q->where('destinations.id', $request->destination_id)
            );
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', fn ($q) =>
                $q->where('destination_categories.id', $request->category_id)
            );
        }

        if ($request->filled('arrival_point_id')) {
            $query->whereHas('arrivalPoints', fn ($q) =>
                $q->where('arrival_points.id', $request->arrival_point_id)
            );
        }

        // Include day plans if requested
        if ($request->boolean('with_day_plans')) {
            $query->with([
                'dayPlans.destination:id,name',
                'dayPlans.activities:id,name',
            ]);
        }

        return PackageResource::collection(
            $query->orderBy('name')->get()
        );
    }

    /**
     * Package detail (always with day plans)
     */
    public function show(Package $package)
    {
        $package->load([
            'destinations:id,name',
            'categories:id,name,icon',
            'arrivalPoints:id,name',
            'dayPlans.destination:id,name',
            'dayPlans.activities:id,name',
        ]);

        return new PackageDetailResource($package);
    }
}
