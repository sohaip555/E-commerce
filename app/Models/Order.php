<?php

namespace App\Models;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Number as Number2;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'grand_total' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_id' => 'integer',
    ];


    public static function getForm(Form $form)
    {
        return $form
            ->schema([
                Section::make('Order Information')
                    ->schema([

                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpan(1)
                            ->required(),
                        Select::make('payment_method')
                            ->options([
                                'stripe' => 'Stripe',
                                'cod' => 'Cash on Delivery',
                            ])
                            ->columnSpan(1),
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->default('pending')
                            ->columnSpan(1)
                            ->required(),
                        Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'GBP' => 'GBP',
                            ])
                            ->default('USD')
                            ->columnSpan(1)
                            ->required(),
                        Select::make('shipping_method')
                            ->label('Shipping Amount')
                            ->options([
                                'flat_rate' => 'Flat Rate',
                                'free' => 'Free Shipping',
                                'local_pickup' => 'Local Pickup',
                            ]),
                        ToggleButtons::make('status')
                            ->options([
                                'new' => 'New',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->inline()
                            ->icons([
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-o-truck',
                                'delivered' => 'heroicon-o-check-circle',
                                'cancelled' => 'heroicon-o-x-circle',
                            ])
                            ->columnSpan(2),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpan(2)
                            ->placeholder('Add any additional notes or instructions here...'),
                    ])->columns(2),

                Section::make('Order Items')
                    ->schema([
                        Repeater::make('orderItems')
                            ->label('Items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label('Product')
                                    ->preload()
                                    ->searchable()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $product = \App\Models\Product::find($get('product_id'));
                                        $set('unit_amount', $product->price);
                                        $set('total_amount', $product->price * $get('quantity'));
                                    })
                                    ->columnSpan(2)
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->reactive()
                                    ->default(1)
                                    ->minValue(1)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $total_amount = $state * $get('unit_amount');
                                        $set('total_amount', $total_amount );
                                    })
                                    ->columnSpan(2)
                                    ->required(),
                                TextInput::make('unit_amount')
                                    ->label('Unit Price')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2)
                                    ->required(),
                                TextInput::make('total_amount')
                                    ->label('Total Price')
                                    ->columnSpan(2)
                                    ->required(),
                            ])
                            ->columns(8)
                            ->createItemButtonLabel('Add Item'),


                        Placeholder::make('total_amount')
                            ->label('Total Price')
                            ->content(function (callable $get, Set $set) {
                                $total = 0;
                                if (!$get('orderItems')) {
                                    return Number2::currency($total, $get('currency'));
                                }

                                foreach ($get('orderItems') as $item) {
                                    $total += $item['total_amount'];
                                }
                                $set('grand_total', $total);
                                return Number2::currency($total, $get('currency'));
                            }),
                        Hidden::make('grand_total')
                            ->default(0),
                    ]),
            ]);
    }

    protected static function getMyTable($disaable = false)
    {
        return [
            TextColumn::make('user.name')
                ->numeric()
                ->searchable()
                ->sortable(),
            TextColumn::make('grand_total')
                ->numeric()
                ->sortable(),
            TextColumn::make('payment_method')
                ->searchable(),
            TextColumn::make('payment_status')
                ->searchable(),
            TextColumn::make('currency')
                ->searchable(),
            SelectColumn::make('status')
                ->label('Status1')
                ->hidden($disaable)
                ->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ]),
            TextColumn::make('shipping_method')
                ->searchable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('update_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product(): HasOne|Order
    {
        return $this->hasOne(Product::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
