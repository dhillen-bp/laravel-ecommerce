<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User & Cart';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('password')->password()->revealable(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('phone_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Select::make('province_id')
                    ->label('Province')
                    ->options(Province::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('city_id', null)),
                Select::make('city_id')
                    ->label('City')
                    ->options(function (callable $get) {
                        $provinceId = $get('province_id');
                        return $provinceId
                            ? City::where('province_id', $provinceId)->pluck('name', 'id')
                            : [];
                    })
                    ->searchable(),
                Textarea::make('address'),
                TextInput::make('postal_code')->numeric()->rule('digits:5'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('email_verified')
                    ->label('Email Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Verified' : 'Unverified')
                    ->color(fn($state): string => $state ? 'success' : 'danger')
                    ->getStateUsing(fn($record) => $record->email_verified_at !== null),
                TextColumn::make('roles')
                    ->label('Roles')
                    ->formatStateUsing(fn($record) => $record->getRoleNames()->join(', '))
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
