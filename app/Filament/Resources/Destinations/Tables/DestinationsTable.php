<?php

namespace App\Filament\Resources\Destinations\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DestinationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->height(50)
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state.name')
                    ->label('State')
                    ->sortable(),

                TextColumn::make('arrivalPoint.name')
                    ->label('Arrival Point'),

                TagsColumn::make('categories.name')
                    ->label('Categories'),

                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
            ]);
    }
}
