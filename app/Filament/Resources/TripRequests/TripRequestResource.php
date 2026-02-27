<?php

namespace App\Filament\Resources\TripRequests;


use App\Filament\Resources\TripRequests\Pages\ListTripRequests;
use App\Filament\Resources\TripRequests\Tables\TripRequestsTable;
use App\Models\TripRequest;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class TripRequestResource extends Resource
{
    protected static ?string $model = TripRequest::class;

    protected static string|UnitEnum|null $navigationGroup = 'Trips';

     // ✅ Add Navigation Icon (Heroicons v3)
    protected static string|BackedEnum|null $navigationIcon =
    'heroicon-o-clipboard-document-list';

    protected static string|BackedEnum|null $activeNavigationIcon =
        'heroicon-s-clipboard-document-list';

    protected static ?string $recordTitleAttribute = 'reference_code';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return TripRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTripRequests::route('/'),
            'manage' => Pages\ManageTrip::route('/{record}/manage'),
        ];
    }
}
