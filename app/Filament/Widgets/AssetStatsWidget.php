<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Checkout;
use App\Models\Location;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalAssets = Asset::count();
        $availableAssets = Asset::whereDoesntHave('checkouts', function ($query) {
            $query->whereNull('date_returned');
        })->count();
        $checkedOutAssets = Asset::whereHas('checkouts', function ($query) {
            $query->whereNull('date_returned');
        })->count();
        $totalLocations = Location::count();

        return [
            Stat::make('Total Assets', $totalAssets)
                ->description('All tracked assets')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            
            Stat::make('Available Assets', $availableAssets)
                ->description('Currently available for checkout')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Checked Out', $checkedOutAssets)
                ->description('Currently checked out')
                ->descriptionIcon('heroicon-m-arrow-right-circle')
                ->color('warning'),
            
            Stat::make('Storage Locations', $totalLocations)
                ->description('Total storage locations')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('info'),
        ];
    }
}
