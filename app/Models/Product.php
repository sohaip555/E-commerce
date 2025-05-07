<?php

namespace App\Models;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class  Product extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_feature' => 'boolean',
        'in_stock' => 'boolean',
        'on_sale' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'category_id' => 'integer',
        'brand_id' => 'integer',
    ];

    public static function getForm(\Filament\Forms\Form $form)
    {
        return $form
            ->schema([
                    Section::make('Product Info')
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->columnSpan(2),
                            ]
                        )->columnSpan(2),

                   Section::make()->schema([
                       Section::make('Price')
                           ->schema([
                               TextInput::make('price')
                                   ->required()
                                   ->numeric()
                                   ->prefix('$'),
                           ])->columnSpan(1),
                       Section::make('Associations')
                           ->schema([
                               Select::make('category_id')
                                   ->relationship('category', 'name')
                                   ->required(),
                               Select::make('brand_id')
                                   ->relationship('brand', 'name')
                                   ->required(),
                           ])->columnSpan(1),

                      Section::make('status')
                          ->schema([
                              Toggle::make('is_active')
                                  ->required(),
                              Toggle::make('is_feature')
                                  ->required(),
                              Toggle::make('in_stock')
                                  ->required(),
                              Toggle::make('on_sale')
                                  ->required(),
                          ])
                   ])->columnSpan(1),
                    Section::make('Images')
                        ->schema([
                            FileUpload::make('images') ,
                        ])->columnSpan(2),
                ])->columns(3);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
