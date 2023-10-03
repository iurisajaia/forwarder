<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DangerStatusResource\Pages;
use App\Filament\Resources\DangerStatusResource\RelationManagers;
use App\Models\DangerStatus;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DangerStatusResource extends Resource
{
    protected static ?string $model = DangerStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDangerStatuses::route('/'),
            'create' => Pages\CreateDangerStatus::route('/create'),
            'edit' => Pages\EditDangerStatus::route('/{record}/edit'),
        ];
    }
}
