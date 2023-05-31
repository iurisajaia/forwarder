<?php

namespace App\Filament\Widgets;

use App\Models\CarType;
use App\Models\User;
use App\Models\UserRole;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Users', User::count()),
            Card::make('User Roles', UserRole::count()),
            Card::make('Car Types', CarType::count()),
        ];
    }
}
