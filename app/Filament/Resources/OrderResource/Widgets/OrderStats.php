<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::all()->count())
                ->label('Total Orders')
                ->value(Order::count())
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),
//            Stat::make('Total Revenue')
//                ->label('Total Revenue')
//                ->value(Order::sum('grand_total'))
//                ->icon('heroicon-o-currency-dollar')
//                ->color('primary'),
            Stat::make('Total Customers', User::all()->count())
                ->label('Total Customers')
                ->icon('heroicon-o-users')
                ->color('warning'),
        ];
    }
}
