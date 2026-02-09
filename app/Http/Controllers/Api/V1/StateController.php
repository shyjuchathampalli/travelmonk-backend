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

    public function show(string $slug)
    {
        $state = State::with('country')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return response()->json([
            'id' => $state->id,
            'name' => $state->name,
            'slug' => $state->slug,
            'banner_image' => $this->assetUrl($state->banner_image),
            'thumbnail_image' => $this->assetUrl($state->thumbnail_image),
            'status' => (bool) $state->status,
            'country' => [
                'id' => $state->country->id,
                'name' => $state->country->name,
            ],
        ]);
    }

    private function assetUrl(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }
}
