<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Package Details')
                ->columns(2)
                ->components([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('number_of_days')
                        ->numeric()
                        ->required(),

                    TextInput::make('base_price')
                        ->numeric()
                        ->prefix('₹')
                        ->required(),

                    Toggle::make('status')
                        ->default(true),

                    Textarea::make('description')
                        ->columnSpanFull(),
                ]),

            Section::make('Package Images')
                ->columns(2)
                ->components([
                    FileUpload::make('package_image')
                        ->label('Package Image')
                        ->image()
                        ->disk('public')
                        ->directory('packages')
                        ->visibility('public')
                        ->imagePreviewHeight('200')
                        ->maxSize(2048)
                        ->nullable(),

                    FileUpload::make('route_map_image')
                        ->label('Route Map Image')
                        ->image()
                        ->disk('public')
                        ->directory('packages/routes')
                        ->visibility('public')
                        ->imagePreviewHeight('200')
                        ->maxSize(2048)
                        ->nullable(),
                ]),

            Section::make('Destinations & Categories')
                ->columns(2)
                ->components([
                    MultiSelect::make('destinations')
                        ->relationship('destinations', 'name')
                        ->searchable()
                        ->preload(),

                    MultiSelect::make('categories')
                        ->relationship('categories', 'name')
                        ->searchable()
                        ->preload(),
                ]),

            Section::make('Arrival Points')
                ->components([
                    MultiSelect::make('arrivalPoints')
                        ->relationship('arrivalPoints', 'name')
                        ->searchable()
                        ->preload(),
                ]),
        ]);
    }
}
