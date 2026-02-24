<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Models
use App\Models\Itinerary;
use App\Models\ItineraryActivity;

class TripRequestController extends Controller
{
    /**
     * Smart loader (package OR trip)
     */
    public function loadPackage($slug)
    {
        $package = Package::where('slug', $slug)
        ->firstOrFail();

        $trip = null;

        if (auth()->check()) {
            $trip = TripRequest::with([
                    'arrivalPoint',
                    'childrenDetails',
                    'travelPurposes',
                    'itineraries.destination',
                    'itineraries.activities.activity',
                ])
                ->where('user_id', auth()->id())
                ->where('package_id', $package->id)
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
                'user_id' => auth()->id(),
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

            $this->createItineraryFromPackage($trip);

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
                'itineraries.destination',
                'itineraries.itineraryActivities.activity',
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

    private function createItineraryFromPackage(TripRequest $trip)
    {
        \Log::info('Generating itineraries...');

        $package = Package::with([
            'dayPlans.activities'
        ])->findOrFail($trip->package_id);

        foreach ($package->dayPlans as $day) {

        \Log::info('Day: ' . $day->day_number . ', Destination ID: ' . ($day->destination_id ?? null));

            $itinerary = Itinerary::create([
                'trip_request_id' => $trip->id,
                'package_id' => $package->id,
                'day_number' => $day->day_number,
                'destination_id' => $day->destination_id,
                'status' => 'pending'
            ]);

            foreach ($day->activities as $activity) {

                ItineraryActivity::create([
                    'trip_request_id' => $trip->id,
                    'itinerary_id' => $itinerary->id,
                    'activity_id' => $activity->id,
                    'status' => 'pending'
                ]);
            }
        }
    }

    public function update(Request $request, TripRequest $trip)
    {
        $request->validate([
            'arrival_date' => 'required|date',
            'end_date' => 'required|date',
            'number_of_days' => 'required|integer|min:1',
            'arrival_point_id' => 'required|exists:arrival_points,id',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
        ]);

        // ✅ Update main columns
        $trip->update([
            'arrival_date' => $request->arrival_date,
            'end_date' => $request->end_date,
            'number_of_days' => $request->number_of_days,
            'arrival_point_id' => $request->arrival_point_id,
            'adults' => $request->adults,
            'children' => $request->children,
            'stay_option' => $request->stay_option,
            'transport_option' => $request->transport_option,
        ]);

        /*
        |--------------------------------------------------------------------------
        | ✅ Travel Purpose Sync
        |--------------------------------------------------------------------------
        */

        if ($request->filled('travel_purpose_id')) {
            $trip->travelPurposes()->sync([
                $request->travel_purpose_id
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ✅ Children Ages Sync
        |--------------------------------------------------------------------------
        */

        // remove old children
        $trip->childrenDetails()->delete();

        $ages = array_slice(
            $request->children_ages ?? [],
            0,
            $request->children
        );

        foreach ($ages as $age) {
            $trip->childrenDetails()->create([
                'age' => $age
            ]);
        }

        return response()->json([
            'success' => true,
            'mode' => 'trip',
            'data' => $trip->fresh()->load([
                'childrenDetails',
                'travelPurposes',
                'arrivalPoint'
            ])
        ]);
    }
}
