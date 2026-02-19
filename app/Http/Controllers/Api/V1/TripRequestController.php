<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripRequestController extends Controller
{
    /**
     * Smart loader (package OR trip)
     */
    public function loadPackage($slug)
    {
        $package = Package::where('slug', $slug)
            ->with(['itineraries.activities'])
            ->firstOrFail();

        $trip = null;

        if (auth()->check()) {
            $trip = TripRequest::with([
                    'itineraries.activities',
                    'childrenDetails',
                    'travelPurposes'
                ])
                ->where('user_id', auth()->id())
                ->where('package_id', $package->id)
                ->where('status', 'draft')
                ->latest()
                ->first();
        }

        if ($trip) {
            return response()->json([
                'mode' => 'trip',
                'data' => $trip
            ]);
        }

        return response()->json([
            'mode' => 'package',
            'data' => $package
        ]);
    }

    /**
     * Save Trip Request
     */
    public function store(Request $request)
    {
        //dd('STORE METHOD HIT');
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'arrival_point_id' => 'required|exists:arrival_points,id',
            'arrival_date' => 'required|date',
            'end_date' => 'required|date',
            'number_of_days' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'children_ages' => 'array',
            'travel_purpose_id' => 'nullable|exists:travel_purposes,id',
            'stay_option' => 'nullable|string',
            'transport_option' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

          \Log::info('Creating trip with data:', $request->all());

            // Create TripRequest
            $trip = TripRequest::create([
                'user_id' => auth()->id() ?? 1,
                'package_id' => $request->package_id,
                'arrival_point_id' => $request->arrival_point_id,
                'arrival_date' => $request->arrival_date,
                'end_date' => $request->end_date,
                'number_of_days' => $request->number_of_days,
                'adults' => $request->adults,
                'children' => $request->children,
                'stay_option' => $request->stay_option,
                'transport_option' => $request->transport_option,
                'status' => 'in_progress',
            ]);

            // Save Travel Purpose
            if ($request->travel_purpose_id) {
                $trip->travelPurposes()->sync([$request->travel_purpose_id]);
            }

            // Save Children Ages
            if ($request->children > 0 && $request->children_ages) {
                foreach ($request->children_ages as $age) {
                    $trip->childrenDetails()->create([
                        'age' => $age
                    ]);
                }
            }

            DB::commit();

            // Reload full data
            $trip->load([
                'childrenDetails',
                'travelPurposes',
            ]);

            return response()->json([
                'success' => true,
                'mode' => 'trip',
                'data' => $trip
            ]);

        } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
    }
}
