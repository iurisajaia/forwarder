<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Facades\Hash;
use Closure;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name'),
                    TextInput::make('email'),
                    TextInput::make('phone'),
                    Select::make('user_role_id')
                        ->relationship('role', 'title')
                        ->preload()
                        ->required()
                        ->reactive(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->hidden(fn (Closure $get) => $get('user_role_id') !== 6),
                    Select::make('car_type_id')
                        ->relationship('car', 'title')
                        ->preload()
                        ->hidden(fn (Closure $get) => $get('user_role_id') !== 4)
                    ,
                    KeyValue::make('meta_info'),
                ]),
                Card::make([
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('drivers_license')
                            ->collection('drivers_license')
                            ->multiple()
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('tech_passport')
                            ->multiple()
                            ->collection('tech_passport')
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('passport')
                            ->multiple()
                            ->collection('passport')
                            ->enableReordering()
                    ])
                ])->hidden(fn (Closure $get) => $get('user_role_id') !== 4),
                Card::make([
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('residence_confirmation')
                            ->collection('residence_confirmation')
                            ->multiple()
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('bank_credentials')
                            ->multiple()
                            ->collection('bank_credentials')
                            ->enableReordering()
                    ]),
                ])->hidden(fn (Closure $get) => $get('user_role_id') !== 2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role.title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RoleRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
