<?php

namespace App\Filament\Resources\CheckoutResource\Pages;

use App\Filament\Resources\CheckoutResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCheckout extends ViewRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
