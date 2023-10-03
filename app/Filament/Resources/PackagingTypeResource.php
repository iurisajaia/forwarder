<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackagingTypeResource\Pages;
use App\Filament\Resources\PackagingTypeResource\RelationManagers;
use App\Models\PackagingType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackagingTypeResource extends Resource
{
    protected static ?string $model = PackagingType::class;

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
            'index' => Pages\ListPackagingTypes::route('/'),
            'create' => Pages\CreatePackagingType::route('/create'),
            'edit' => Pages\EditPackagingType::route('/{record}/edit'),
        ];
    }
}
