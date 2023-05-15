<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserRole extends ViewRecord
{
    protected static string $resource = UserRoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
