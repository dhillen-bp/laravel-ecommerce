<?php

namespace App\Filament\Resources\CartResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'cart_items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->relationship('product_variant')
                    ->schema([
                        Group::make()
                            ->relationship('product')
                            ->schema([
                                FileUpload::make('image')->required()->image()->directory('products')->disabled()->label("Product Image"),
                            ]),
                    ]),

                Group::make()
                    ->relationship('product_variant')
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

                Placeholder::make('sub_total_price')
                    ->label('Sub Total Price')
                    ->content(fn ($record) => $record
                        ? number_format($record->product_variant->price * $record->quantity, 2)
                        : '0.00'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ImageColumn::make('product_variant.product.image')->label("Product Image"),
                ImageColumn::make('product_variant.variant.image')->label("Variant Image"),
                TextColumn::make('product_variant.product.name'),
                TextColumn::make('product_variant.variant.name'),
                TextColumn::make('quantity'),
                TextColumn::make('sub_total_price')
                    ->label('Sub Total Price')
                    ->getStateUsing(fn ($record) => $record->product_variant->price * $record->quantity)
                    ->money('IDR')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
