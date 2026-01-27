<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Package;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Destinations Listed', Destination::count())
                ->icon('heroicon-o-map'),

            Stat::make('Packages', Package::count())
                ->icon('heroicon-o-archive-box'),

            Stat::make('Active Vendors', Vendor::where('status', true)->count())
                ->icon('heroicon-o-building-storefront'),

            Stat::make('Active Activities', Activity::where('status', true)->count())
                ->icon('heroicon-o-sparkles'),
        ];
    }
}
