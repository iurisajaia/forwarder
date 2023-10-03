<?php

namespace App\Filament\Resources\DangerStatusResource\Pages;

use App\Filament\Resources\DangerStatusResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDangerStatuses extends ListRecords
{
    protected static string $resource = DangerStatusResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
