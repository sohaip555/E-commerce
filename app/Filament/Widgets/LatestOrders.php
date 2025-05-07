<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns(
                [
                    TextColumn::make('id')
                        ->label('Order ID')
                        ->sortable()
                        ->searchable()
                        ->toggleable(),
                    TextColumn::make('user.name')
                        ->numeric()
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('status')
                        ->badge()
                        ->color(function ($state) {
                            return match ($state) {
                                'new' => 'success',
                                'processing' => 'warning',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            };
                        })
                        ->icon(function ($state) {
                            return match ($state) {
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-o-truck',
                                'delivered' => 'heroicon-o-check-circle',
                                'cancelled' => 'heroicon-o-x-circle',
                                default => null,
                            };
                        }),
                    TextColumn::make('grand_total')
                        ->numeric()
                        ->sortable(),
                    TextColumn::make('payment_method')
                        ->searchable(),
                    TextColumn::make('payment_status')
                        ->searchable()
                        ->badge(),
                ])
            ->actions(
                [
                    Tables\Actions\Action::make('View Order')
                        ->url(fn ($record) => OrderResource::getUrl('view', ['record' => $record])),
                ]);
    }
}
