<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArrivalPointResource;
use App\Models\ArrivalPoint;
use Illuminate\Http\Request;

class ArrivalPointController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'state_id' => ['required', 'integer', 'exists:states,id'],
        ]);

        $arrivalPoints = ArrivalPoint::where('state_id', $request->state_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return ArrivalPointResource::collection($arrivalPoints);
    }

    public function search(Request $request)
    {
        $query = $request->get('query'); // ✅ CORRECT

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $arrivalPoints = ArrivalPoint::where('name', 'like', "%{$query}%")
            ->where('status', true)
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($arrivalPoints);
    }
}
