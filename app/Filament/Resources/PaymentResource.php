<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationGroup = 'Order & Payment';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')->disabled(),
                TextInput::make('transaction_id')->disabled(),
                TextInput::make('gross_amount')->disabled(),
                TextInput::make('transaction_time')->disabled(),
                TextInput::make('payment_type')->disabled(),
                TextInput::make('bank')->disabled(),
                TextInput::make('midtrans_status')->disabled(),
                Select::make('status')
                    ->options([
                        'success' => 'Success',
                        'pending' => 'Pending',
                        'failed' => 'Failed',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')->sortable(),
                TextColumn::make('transaction_id')->sortable()->searchable(),
                TextColumn::make('transaction_time')->sortable()->searchable(),
                TextColumn::make('gross_amount')->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        'pending' => 'warning',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }
}
