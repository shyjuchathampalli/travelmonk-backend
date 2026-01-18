<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Vendor Information')
                ->columns(2)
                ->components([
                    FileUpload::make('image')
                        ->label('Vendor Image')
                        ->image()
                        ->disk('public')
                        ->directory('vendors')
                        ->visibility('public')
                        ->imagePreviewHeight('150')
                        ->maxSize(2048)
                        ->nullable(),

                    TextInput::make('business_name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('contact_name')
                        ->maxLength(255),

                    TextInput::make('email')
                        ->email(),

                    TextInput::make('phone')
                        ->tel(),

                    TextInput::make('price_range')
                        ->placeholder('₹₹₹'),

                    Toggle::make('status')
                        ->default(true),
                ]),

            Section::make('Destination Mapping')
                ->columns(2)
                ->components([
                    Select::make('destination_id')
                        ->relationship('destination', 'name')
                        ->searchable()
                        ->required(),

                    Select::make('destination_category_id')
                        ->relationship('destinationCategory', 'name')
                        ->searchable()
                        ->required(),
                ]),

            Section::make('Additional Details')
                ->components([
                    Textarea::make('caption')
                        ->rows(2),

                    Textarea::make('details')
                        ->rows(4),
                ]),
        ]);
    }
}
