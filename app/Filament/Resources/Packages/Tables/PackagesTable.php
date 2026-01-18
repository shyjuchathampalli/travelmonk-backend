<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('package_image')
                    ->label('Package')
                    ->disk('public')
                    ->height(50)
                    ->circular(),

                ImageColumn::make('route_map_image')
                    ->label('Route')
                    ->disk('public')
                    ->height(50),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('number_of_days')
                    ->label('Days')
                    ->sortable(),

                TextColumn::make('base_price')
                    ->money('INR'),

                TagsColumn::make('destinations.name')
                    ->label('Destinations'),

                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
            ]);
    }
}
