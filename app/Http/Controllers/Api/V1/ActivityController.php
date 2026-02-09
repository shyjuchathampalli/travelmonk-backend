<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * 1️⃣ General activities (no destination)
     */
    public function general()
    {
        $activities = Activity::whereNull('destination_id')
            ->where('type', 'general')
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return ActivityResource::collection($activities);
    }

    /**
     * 2️⃣ Destination-specific activities
     */
    public function byDestination(Request $request)
    {
        $request->validate([
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
        ]);

        $activities = Activity::where('destination_id', $request->destination_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return ActivityResource::collection($activities);
    }
}
