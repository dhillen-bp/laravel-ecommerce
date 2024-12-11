<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MonthlyPaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Payment Chart';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
            ->query(Payment::where('status', 'success'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        // dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi perbulan',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn ($item) => Carbon::parse($item->date)->format('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
