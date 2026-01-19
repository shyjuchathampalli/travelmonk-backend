<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
        ]);

        $states = State::where('country_id', $request->country_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return StateResource::collection($states);
    }
}
