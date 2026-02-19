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
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $arrivalPoints = ArrivalPoint::where('status', true)
            ->where('name', 'like', '%' . $request->query . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return ArrivalPointResource::collection($arrivalPoints);
    }
}
