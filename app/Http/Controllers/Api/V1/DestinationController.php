<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DestinationResource;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * List destinations with filters
     */
    public function index(Request $request)
    {
        $query = Destination::query()
            ->where('status', true)
            ->with(['state', 'arrivalPoint', 'categories']);

        // Filter by state
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        // Filter by arrival point
        if ($request->filled('arrival_point_id')) {
            $query->where('arrival_point_id', $request->arrival_point_id);
        }

        // Filter by category (many-to-many)
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('destination_categories.id', $request->category_id);
            });
        }

        return DestinationResource::collection(
            $query->orderBy('name')->get()
        );
    }
}
