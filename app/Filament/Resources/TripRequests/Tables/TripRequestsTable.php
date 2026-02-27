<?php

namespace App\Filament\Resources\TripRequests\Tables;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use App\Filament\Resources\TripRequests\TripRequestResource;

class TripRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('arrival_date')
                    ->date(),

                TextColumn::make('end_date')
                    ->date(),

                TextColumn::make('number_of_days')
                    ->label('Days'),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'in_progress',
                        'warning' => 'quote_requested',
                        'primary' => 'priced',
                        'success' => 'confirmed',
                        'danger' => 'abandoned',
                    ]),

                TextColumn::make('final_price')
                    ->money('GBP')
                    ->label('Final Price'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'quote_requested' => 'Quote Requested',
                        'priced' => 'Priced',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
    Action::make('manage')
        ->label('Manage Trip')
        ->icon('heroicon-o-cog-6-tooth')
        ->url(fn ($record) =>
            TripRequestResource::getUrl('manage', ['record' => $record])
        ),
]);
    }
}
