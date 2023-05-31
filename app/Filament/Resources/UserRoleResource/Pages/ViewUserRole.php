<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserRole extends ViewRecord
{
    protected static string $resource = UserRoleResource::class;
    use ViewRecord\Concerns\Translatable;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }
}
