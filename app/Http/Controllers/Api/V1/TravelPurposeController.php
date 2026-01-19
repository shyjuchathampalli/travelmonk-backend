<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TravelPurposeResource;
use App\Models\TravelPurpose;
use Illuminate\Http\Request;

class TravelPurposeController extends Controller
{
    /**
     * List all active travel purposes
     */
    public function index(Request $request)
    {
        $purposes = TravelPurpose::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return TravelPurposeResource::collection($purposes);
    }
}
