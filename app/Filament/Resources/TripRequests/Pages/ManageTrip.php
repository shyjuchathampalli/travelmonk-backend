<?php

namespace App\Filament\Resources\TripRequests\Pages;

use App\Filament\Resources\TripRequests\TripRequestResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\Vendor;
use App\Models\Itinerary;
use App\Models\ItineraryActivity;


use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;

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

                                TextInput::make('package_cost')
                                    ->label('Package Cost')
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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('savePricing')
                ->label('Save Pricing')
                ->icon('heroicon-o-check')
                ->color('primary')
                ->visible(fn () => $this->record->status === 'quote_requested')
                ->action(function () {

                    $data = $this->form->getState();

                    $this->record->update([
                        'package_cost' => $data['package_cost'],
                        'margin_percent' => $data['margin_percent'],
                        'final_price' => $data['final_price'],
                        'status' => 'priced',
                    ]);

                    $this->notify('success', 'Quote saved successfully');
                }),
        ];
    }

    public function savePricing()
    {
        $data = $this->form->getState();

        $this->record->update([
            'final_price' => $data['final_price'],
        ]);

        $this->notify('success', 'Pricing updated successfully');
    }


}
