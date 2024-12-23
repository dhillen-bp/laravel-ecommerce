<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Filament\Resources\OrderItemResource\RelationManagers;
use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')->disabled()->columnSpanFull(),
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
                TextInput::make('quantity')
                    ->numeric()->disabled(),
                TextInput::make('price')->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()->disabled(),
                Group::make()
                    ->relationship('productVariant')
                    ->schema([
                        Group::make()
                            ->relationship('product')
                            ->schema([
                                FileUpload::make('image')->required()->image()->directory('products/variants')->disabled(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')->sortable(),
                ImageColumn::make('productVariant.variant.image')->size(60),
                TextColumn::make('productVariant.product.name')->label("Product Name")->searchable()->sortable(),
                TextColumn::make('productVariant.variant.name')->label("Variant Name")->searchable()->sortable(),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('price')
                    ->money('IDR')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'view' => Pages\ViewOrderItem::route('/{record}'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
