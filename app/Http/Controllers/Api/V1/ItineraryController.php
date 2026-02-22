<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\Itinerary;
use App\Models\ItineraryActivity;

class ItineraryController extends Controller
{
    public function syncActivities(Request $request, Itinerary $itinerary)
    {

        if ($itinerary->tripRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'activity_ids' => 'array'
        ]);

        $activityIds = $request->activity_ids ?? [];

        $tripId = $itinerary->trip_request_id;

        // Remove unchecked activities
        ItineraryActivity::where('itinerary_id', $itinerary->id)
            ->whereNotIn('activity_id', $activityIds)
            ->delete();

        // Add new selections
        foreach ($activityIds as $activityId) {

            ItineraryActivity::firstOrCreate([
                'trip_request_id' => $tripId,
                'itinerary_id' => $itinerary->id,
                'activity_id' => $activityId,
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function updateNotes(Request $request, Itinerary $itinerary)
    {
        if ($itinerary->tripRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:200'
        ]);

        $itinerary->update([
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'data' => $itinerary
        ]);
    }
}
