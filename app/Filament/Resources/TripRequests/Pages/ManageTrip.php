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
        return $schema->schema([

            Section::make('Pricing')
                ->schema([

                    Grid::make(3)->schema([

                        TextInput::make('package_cost')
                            ->label('Package Cost')
                            ->numeric()
                            ->prefix('£')
                            ->live(),

                        TextInput::make('margin_percent')
                            ->numeric()
                            ->suffix('%')
                            ->live(),

                        TextInput::make('final_price')
                            ->prefix('£')
                            ->disabled()
                            ->dehydrated(false) // ⭐ VERY IMPORTANT
                            ->formatStateUsing(function ($state, $livewire) {

                                $cost = $livewire->form->getState()['package_cost'] ?? 0;
                                $margin = $livewire->form->getState()['margin_percent'] ?? 0;

                                if (!$cost) return null;

                                return round($cost + ($cost * $margin / 100), 2);
                            }),

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
                ->visible(fn () =>
                    $this->record->status === 'quote_requested'
                )
                ->action(function () {

                    $data = $this->form->getState();

                    $cost = $data['package_cost'] ?? 0;
                    $margin = $data['margin_percent'] ?? 0;

                    $finalPrice = round(
                        $cost + ($cost * $margin / 100),
                        2
                    );

                    $this->record->update([
                        'package_cost' => $cost,
                        'margin_percent' => $margin,
                        'final_price' => $finalPrice,
                        'status' => 'priced',
                    ]);

                    $this->notify('success', 'Pricing saved successfully');

                    $this->redirect(
                        TripRequestResource::getUrl('index')
                    );
                }),
        ];
    }


}
