<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingRelationManager extends RelationManager
{
    protected static string $relationship = 'shipping';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('courier_code')->disabled(),
                TextInput::make('courier_name')->disabled(),
                TextInput::make('courier_service')->disabled(),
                TextInput::make('courier_service_description')->disabled(),
                TextInput::make('estimate_day')->disabled(),
                TextInput::make('cost')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()->disabled(),
                Group::make()
                    ->relationship('province')
                    ->schema([
                        TextInput::make('name')->label("Province")->disabled(),
                    ]),
                Group::make()
                    ->relationship('city')
                    ->schema([
                        TextInput::make('name')->label("City")->disabled(),
                    ]),
                Textarea::make("address")->disabled(),
                TextInput::make('tracking_number')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('OrderShipping')
            ->columns([
                TextColumn::make('courier_code')->label('Code'),
                TextColumn::make('courier_name')->label('Name'),
                TextColumn::make('courier_service')->label('Service'),
                TextColumn::make('estimate_day')->label('Estimate Day'),
                TextColumn::make('cost')->label('Cost')->money('IDR'),
                TextColumn::make('tracking_number')->label('Tracking Number')->default('-'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
