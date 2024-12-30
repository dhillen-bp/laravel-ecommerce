<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Order & Payment';
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'paid')->count();
    }

    protected static ?string $navigationBadgeTooltip = 'The number of paid orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->disabled(),
                Group::make([
                    TextInput::make('name')->disabled()
                ])
                    ->relationship('user'),
                TextInput::make('total_product_price')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()->disabled(),
                Group::make([
                    TextInput::make('cost')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()->disabled()
                ])->relationship('shipping'),
                TextInput::make('total_order_price')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending (Menunggu)',
                        'paid' => 'Paid (Dibayar)',
                        'processed' => 'Processed (Diproses Pengemasan)',
                        'shipped' => 'Shipped (Dikirim)',
                        'delivered' => 'Delivered (Terkirim)',
                        'completed' => 'Completed (Selesai)',
                        'cancelled' => 'Cancelled (Dibatalkan)',
                    ])->required(),
                // TextInput::make('shipping_cost')->required()
                //     ->mask(RawJs::make('$money($input)'))
                //     ->stripCharacters(',')
                //     ->numeric()->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('total_product_price')
                    ->money('IDR')->sortable(),
                TextColumn::make('shipping.cost')->label('Shipping Cost')
                    ->money('IDR')->sortable(),
                TextColumn::make('total_order_price')
                    ->money('IDR')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'primary-badge',
                        'processed' => 'neutral',
                        'shipped' => 'info',
                        'delivered' => 'accent',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'processed' => 'Processed',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()->color('warning'),
                // Tables\Actions\DeleteAction::make(),
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
            RelationManagers\ShippingRelationManager::class,
            RelationManagers\OrderItemsRelationManager::class,
            RelationManagers\PaymentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
