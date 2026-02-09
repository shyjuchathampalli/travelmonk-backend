<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText('Used in URLs like /trip/kerala'),

            FileUpload::make('banner_image')
                ->label('Banner Image')
                ->image()
                ->directory('states/banners')
                ->imageEditor()
                ->columnSpanFull(),

            FileUpload::make('thumbnail_image')
                ->label('Thumbnail Image')
                ->image()
                ->directory('states/thumbnails')
                ->imageEditor(),

            Toggle::make('status')
                ->label('Active')
                ->default(true),
        ]);
    }
}
