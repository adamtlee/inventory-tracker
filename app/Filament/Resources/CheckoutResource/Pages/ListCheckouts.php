<?php

namespace App\Filament\Resources\CheckoutResource\Pages;

use App\Filament\Resources\CheckoutResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCheckouts extends ListRecords
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
