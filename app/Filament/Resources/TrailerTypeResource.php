<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrailerTypeResource\Pages;
use App\Filament\Resources\TrailerTypeResource\RelationManagers;
use App\Models\TrailerType;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrailerTypeResource extends Resource
{
    use Translatable;

    protected static ?string $model = TrailerType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getTranslatableLocales(): array
    {
        return ['eng', 'geo' ,'tur' , 'rus'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('key')->nullable(),
                FileUpload::make('icon_default')->nullable(),
                FileUpload::make('icon_hover')->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTrailerTypes::route('/'),
            'create' => Pages\CreateTrailerType::route('/create'),
            'view' => Pages\ViewTrailerType::route('/{record}'),
            'edit' => Pages\EditTrailerType::route('/{record}/edit'),
        ];
    }
}
