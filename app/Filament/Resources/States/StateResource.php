<?php

namespace App\Filament\Resources\States;

use App\Models\State;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

// Pages
use App\Filament\Resources\States\Pages\ListStates;
use App\Filament\Resources\States\Pages\CreateState;
use App\Filament\Resources\States\Pages\EditState;

// Schema & Table
use App\Filament\Resources\States\Schemas\StateForm;
use App\Filament\Resources\States\Tables\StatesTable;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'States';

    protected static ?string $slug = 'states';

    /* -------------------------------
     |  FORM (Schema)
     | ------------------------------- */
    public static function form(Schema $schema): Schema
    {
        return StateForm::configure($schema);
    }

    /* -------------------------------
     |  TABLE
     | ------------------------------- */
    public static function table(Table $table): Table
    {
        return StatesTable::configure($table);
    }

    /* -------------------------------
     |  PAGES (CRITICAL)
     | ------------------------------- */
    public static function getPages(): array
    {
        return [
            'index'  => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'edit'   => EditState::route('/{record}/edit'),
        ];
    }
}
