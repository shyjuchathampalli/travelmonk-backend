<?php

namespace App\Filament\Resources\TripRequests\Pages;

use App\Filament\Resources\TripRequests\TripRequestResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use App\Models\TripRequest;

class ManageTrip extends Page
{
    use InteractsWithRecord;

    public TripRequest $trip;

    protected static string $resource = TripRequestResource::class;

    protected string $view = 'filament.resources.trip-requests.pages.manage-trip';

    public function mount($record): void
    {
        $this->trip = TripRequest::with([
            'itineraries.activities.activity',
            'itineraries.destination',
        ])->findOrFail($record);
    }
}
