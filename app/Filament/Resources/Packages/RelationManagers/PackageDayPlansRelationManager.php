<?php

namespace App\Filament\Resources\Packages\RelationManagers;

use App\Models\Activity;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;

class PackageDayPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'dayPlans';

    protected static ?string $title = 'Day Plans';

    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit($record): bool
    {
        return true;
    }

    protected function canDelete($record): bool
    {
        return true;
    }

    /* ---------------- FORM ---------------- */

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('day_number')
                ->label('Day')
                ->numeric()
                ->required(),

            Select::make('destination_id')
                ->label('Destination')
                ->relationship('destination', 'name')
                ->required()
                ->live(),

            Textarea::make('description')
                ->label('Day Description')
                ->rows(3)
                ->columnSpanFull(),

            MultiSelect::make('activities')
                ->label('Activities')
                ->relationship(
                    name: 'activities',
                    titleAttribute: 'name'
                )
                ->options(fn ($get) =>
                    filled($get('destination_id'))
                        ? Activity::where('destination_id', $get('destination_id'))
                            ->where('status', true)
                            ->pluck('name', 'id')
                        : []
                )
                ->visible(fn ($get) => filled($get('destination_id')))
                ->required()
                ->columnSpanFull(),
        ]);
    }

    /* ---------------- TABLE ---------------- */

    public function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('day_number')
                ->label('Day')
                ->sortable(),

            TextColumn::make('destination.name')
                ->label('Destination'),

            TextColumn::make('activities.name')
                ->label('Activities')
                ->badge()
                ->separator(', '),
        ])
        ->headerActions([
            CreateAction::make()
                ->label('Add Day Plan'),
        ])
        ->emptyStateActions([
            CreateAction::make()
                ->label('Add Day Plan'),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
}

}
