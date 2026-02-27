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
                ->formatStateUsing(fn ($state) => match ($state) {
                    'quote_requested' => 'Quote Requested — Needs Pricing',
                    'priced' => 'Quote Prepared',
                    'confirmed' => 'Confirmed',
                    'in_progress' => 'Draft',
                    default => ucfirst($state),
                })
                ->colors([
                    'warning' => 'quote_requested',
                    'primary' => 'priced',
                    'success' => 'confirmed',
                    'gray' => 'in_progress',
                ])
                ->icons([
                    'heroicon-o-currency-pound' => 'quote_requested',
                    'heroicon-o-check-circle' => 'confirmed',
                    'heroicon-o-clock' => 'in_progress',
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
            ->recordActions([
    Action::make('manage')
        ->label('Manage Trip')
        ->icon('heroicon-o-cog-6-tooth')
        ->url(fn ($record) =>
            TripRequestResource::getUrl('manage', ['record' => $record])
        ),
]);
    }
}
