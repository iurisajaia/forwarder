<?php

namespace App\Filament\Resources\DangerStatusResource\Pages;

use App\Filament\Resources\DangerStatusResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDangerStatus extends EditRecord
{
    protected static string $resource = DangerStatusResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
