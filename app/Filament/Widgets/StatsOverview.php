<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $currentYear = now()->year;

        $totalOrders = Order::whereYear('created_at', $currentYear)->count();
        $totalOrdersSuccess = Order::where('status', 'paid')->whereYear('created_at', $currentYear)->count();
        $totalProductRevenue = Order::whereYear('created_at', $currentYear)
            ->where('status', 'paid')
            ->get()
            ->sum(function ($order) {
                return $order->order_items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
            });

        return [
            Stat::make('Total pesanan tahun ini', $totalOrders),
            Stat::make('Total pesanan terbayar tahun ini', $totalOrdersSuccess),
            Stat::make('Total pendapatan tahun ini', 'Rp ' . number_format($totalProductRevenue, 0, ',', '.')),
        ];
    }
}
