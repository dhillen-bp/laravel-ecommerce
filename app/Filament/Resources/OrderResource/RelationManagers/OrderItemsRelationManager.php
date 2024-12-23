<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->relationship('productVariant')
                    ->schema([
                        Group::make()
                            ->relationship('product')
                            ->schema([
                                FileUpload::make('image')->required()->image()->directory('products/variants')->disabled(),
                            ]),
                    ])->columnSpanFull(),
                Group::make()
                    ->relationship('productVariant')
                    ->schema([
                        Group::make()
                            ->relationship('product')
                            ->schema([
                                TextInput::make('name')
                                    ->label("Product Name")
                                    ->disabled(),
                            ]),
                        Group::make()
                            ->relationship('variant')
                            ->schema([
                                TextInput::make('name')
                                    ->label("Variant Name")
                                    ->disabled(),
                            ]),
                    ])->columnSpanFull(),
                TextInput::make('quantity')->disabled(),
                TextInput::make('price')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                // ImageColumn::make('productVariant.variant.image')->label("Image"),
                TextColumn::make('productVariant.product.name'),
                TextColumn::make('productVariant.variant.name'),
                TextColumn::make('quantity'),
                TextColumn::make('price')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
