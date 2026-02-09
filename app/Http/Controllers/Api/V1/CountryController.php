<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * List all active countries
     */
    public function index(Request $request)
    {
        $countries = Country::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return CountryResource::collection($countries);
    }
}
