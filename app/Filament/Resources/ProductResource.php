<?php

namespace App\Filament\Resources;

use App\Filament\Pages\ProductVariant;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant as ModelsProductVariant;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Category & Product';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255)->unique(ignoreRecord: true),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
                // TextInput::make('price')->required()
                //     ->mask(RawJs::make('$money($input)'))
                //     ->stripCharacters(',')
                //     ->numeric(),
                // TextInput::make('stock')->required()->numeric()->minValue(1),
                Select::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
                FileUpload::make('image')->required()->image()->directory('products'),
                RichEditor::make('description')->columnSpanFull()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->size(60),
                TextColumn::make('name')->searchable()->sortable(),

                TextColumn::make('description')->words(3)->html(),
                TextColumn::make('variants')
                    ->label('Stock Variant Pertama')
                    ->getStateUsing(fn($record) => $record->variants->first()->pivot->stock ?? 'N/A')
                    ->sortable(),
                TextColumn::make('variants')
                    ->label('Price Variant Pertama')
                    ->getStateUsing(fn($record) => $record->variants->first()?->pivot->price ?? 'N/A')
                    ->money('IDR')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy(
                            fn($subquery) => $subquery->select('price')
                                ->from('product_variants')
                                ->whereColumn('product_variants.product_id', 'products.id')
                                ->orderBy('product_variants.id')
                                ->limit(1),
                            $direction
                        );
                    }),
                TextColumn::make('is_active')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    }),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label("Is Active")
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
                Tables\Actions\ViewAction::make(),

                // Action::make('detail_variant')
                //     ->label('Detail Variant')  // Label tombol
                //     ->icon('heroicon-o-eye')  // Anda dapat memilih ikon yang sesuai
                //     ->url(fn (Product $record): string =>  self::getUrl('variant', ['product_id' => $record->id]))
                //     ->color('info'),  // Anda bisa memilih warna tombol
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
            RelationManagers\VariantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
            // 'variant' => Pages\ProductVariant::route('/{product_id}/variant'),
        ];
    }
}
