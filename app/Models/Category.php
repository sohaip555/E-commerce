<?php

namespace App\Models;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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
        'is_active' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static  function getForm($form): Form
    {
        return $form
            ->schema(
                    [
                        Section::make([
                                Grid::make()->schema([
                                    TextInput::make('name')
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn($state, Set $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                                        ->required(),
                                    TextInput::make('slug')
                                        ->maxLength(255)
                                        ->disabled()
                                        ->dehydrated()
                                        ->required(),
                                    ]),
                                FileUpload::make('image')
                                    ->image(),
                                Toggle::make('is_active')
                                    ->required(),
                            ])
                    ]
                );
    }
}









