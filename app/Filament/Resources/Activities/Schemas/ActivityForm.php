<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('destination_id')
                ->relationship('destination', 'name')
                ->required()
                ->searchable(),

                Select::make('vendor_id')
                ->relationship('vendor', 'business_name')
                ->nullable()
                ->searchable(),


                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('base_price')
                    ->numeric()
                    ->prefix('$'),
                Select::make('type')
                    ->options(['destination' => 'Destination', 'general' => 'General'])
                    ->default('destination')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
