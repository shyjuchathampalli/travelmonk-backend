<?php

namespace App\Filament\Resources\TripRequests\Pages;

use App\Filament\Resources\TripRequests\TripRequestResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use App\Models\TripRequest;
use App\Models\Vendor;

class ManageTrip extends Page
{
    use InteractsWithRecord;

    public TripRequest $trip;

    public $vendors;

    protected static string $resource = TripRequestResource::class;

    protected string $view = 'filament.resources.trip-requests.pages.manage-trip';

    public function mount($record): void
    {
        $this->trip = TripRequest::with([
            'itineraries.activities.activity',
            'itineraries.destination',
        ])->findOrFail($record);

        $this->vendors = Vendor::pluck('name', 'id');
    }

    public function updateStayVendor($itineraryId, $vendorId)
    {
        \App\Models\Itinerary::where('id', $itineraryId)
            ->update(['stay_vendor_id' => $vendorId]);

        $this->trip->refresh();
    }

    public function updateActivityVendor($activityId, $vendorId)
    {
        \App\Models\ItineraryActivity::where('id', $activityId)
            ->update(['vendor_id' => $vendorId]);

        $this->trip->refresh();
    }
}
