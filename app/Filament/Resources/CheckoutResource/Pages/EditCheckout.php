<?php

namespace App\Filament\Resources\CheckoutResource\Pages;

use App\Filament\Resources\CheckoutResource;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCheckout extends EditRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
