<?php

namespace App\Filament\Resources\PackagingTypeResource\Pages;

use App\Filament\Resources\PackagingTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackagingType extends EditRecord
{
    protected static string $resource = PackagingTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
