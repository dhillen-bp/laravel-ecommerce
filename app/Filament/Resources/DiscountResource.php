<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')->required(),
                TextInput::make('name')->required(),
                Textarea::make('description')->nullable(),
                Select::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
                    ->required(),
                DateTimePicker::make('start_date')->required(),
                DateTimePicker::make('end_date')->required(),
                TextInput::make('claim_limit')->numeric()->minValue(1),
                TextInput::make('claimed')->numeric()->default(0),
                Select::make('type')
                    ->options([
                        'fixed' => 'Nominal Fixed',
                        'percentage' => 'Percentage',
                    ])
                    ->required()
                    ->reactive(),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->disabled(fn ($get) => $get('type') !== 'fixed')
                    ->required(fn ($get) => $get('type') === 'fixed'),
                TextInput::make('percentage')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->disabled(fn ($get) => $get('type') !== 'percentage')
                    ->required(fn ($get) => $get('type') === 'percentage'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('name'),
                TextColumn::make('type'),
                // TextColumn::make('type')->label('Type')
                //     ->money('IDR')->sortable(),
                TextColumn::make('is_active')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn (string $state): string => match ($state) {
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
            'view' => Pages\ViewDiscount::route('/{record}'),
        ];
    }
}
