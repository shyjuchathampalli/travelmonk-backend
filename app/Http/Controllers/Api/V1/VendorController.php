<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * List vendors with filters
     */
    public function index(Request $request)
    {
        $query = Vendor::query()
            ->where('status', true)
            ->with([
                'destination:id,name',
                'destinationCategory:id,name',
            ]);

        // Filter by destination
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        // Filter by destination category
        if ($request->filled('destination_category_id')) {
            $query->where(
                'destination_category_id',
                $request->destination_category_id
            );
        }

        return VendorResource::collection(
            $query->orderBy('business_name')->get()
        );
    }
}
