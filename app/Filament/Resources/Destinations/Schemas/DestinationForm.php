<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Basic Information')
                ->columns(2)
                ->components([
                    FileUpload::make('image')
                        ->label('Destination Image')
                        ->image()
                        ->disk('public')
                        ->directory('destinations')
                        ->visibility('public')
                        ->imagePreviewHeight('200')
                        ->maxSize(2048) // 2MB
                        ->nullable(),

                    Select::make('state_id')
                    ->label('State')
                    ->relationship(
                        name: 'state',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('country_id', 1)
                    )
                    ->searchable()
                    ->required(),

                    Select::make('arrival_point_id')
                    ->label('Arrival Point')
                    ->options(fn (callable $get) =>
                        $get('state_id')
                            ? \App\Models\ArrivalPoint::query()
                                ->where('state_id', $get('state_id'))
                                ->where('status', true)
                                ->pluck('name', 'id')
                            : []
                    )
                    ->searchable()
                    ->nullable(),

                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('description')
                        ->columnSpanFull(),

                    MultiSelect::make('categories')
                        ->relationship('categories', 'name')
                        ->searchable()
                        ->preload(),
                ]),

            Section::make('Location & Status')
                ->columns(3)
                ->components([
                    TextInput::make('latitude')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('longitude')
                        ->numeric()
                        ->nullable(),

                    Toggle::make('status')
                        ->default(true),
                ]),
        ]);
    }
}
