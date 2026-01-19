<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DestinationCategoryResource;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;

class DestinationCategoryController extends Controller
{
    /**
     * List all active destination categories
     */
    public function index(Request $request)
    {
        $categories = DestinationCategory::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return DestinationCategoryResource::collection($categories);
    }
}
