<?php

namespace App\Filament\Resources\Vendors\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VendorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->height(40)
                    ->circular(),

                TextColumn::make('business_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('destination.name')
                    ->label('Destination')
                    ->sortable(),

                TextColumn::make('destinationCategory.name')
                    ->label('Category'),

                TextColumn::make('phone')
                    ->searchable(),

                TextColumn::make('price_range'),

                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),

                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
