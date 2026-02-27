<?php

namespace App\Filament\Resources\TripRequests\Pages;

use App\Filament\Resources\TripRequests\TripRequestResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\Vendor;
use App\Models\Itinerary;
use App\Models\ItineraryActivity;


use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;

class ManageTrip extends Page
{
    use InteractsWithRecord;

    protected static string $resource = TripRequestResource::class;

    protected string $view = 'filament.resources.trip-requests.pages.manage-trip';

    public $vendors = [];

    public function mount($record): void
    {
        // Let Filament resolve the record
        $this->record = $this->resolveRecord($record);

        // Eager load relationships
        $this->record->load([
            'itineraries.activities.activity',
            'itineraries.destination',
        ]);

        // Load vendors properly
        $this->vendors = Vendor::pluck('business_name', 'id')->toArray();
    }

    public function updateStayVendor($itineraryId, $vendorId)
    {
        Itinerary::where('id', $itineraryId)
            ->update(['stay_vendor_id' => $vendorId ?: null]);

        $this->record->refresh();
        $this->record->load('itineraries.activities.activity', 'itineraries.destination');
    }

    public function updateActivityVendor($activityId, $vendorId)
    {
        ItineraryActivity::where('id', $activityId)
            ->update(['vendor_id' => $vendorId ?: null]);

        $this->record->refresh();
        $this->record->load('itineraries.activities.activity', 'itineraries.destination');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Pricing')
                    ->schema([
                        Grid::make(3)
                            ->schema([

                                TextInput::make('transport_cost')
                                    ->numeric()
                                    ->prefix('£'),

                                TextInput::make('margin_percent')
                                    ->numeric()
                                    ->suffix('%'),

                                TextInput::make('final_price')
                                    ->disabled()
                                    ->prefix('£'),

                            ]),
                    ])
                    ->visible(fn () =>
                        $this->record->status === 'quote_requested'
                    ),
            ]);
    }
}
