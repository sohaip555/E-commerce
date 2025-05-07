<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function initials()
    {
        $name = $this->name;
        $initials = '';

        $names = explode(' ', $name);

        foreach ($names as $word) {
            $initials .= strtoupper(substr($word, 0, 1));

            // Limit to 2 initials if you prefer
            if (strlen($initials) >= 2) {
                break;
            }
        }

        return $initials;
    }

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->confirmed()
                ->minLength(8)
                ->maxLength(255)
                ->dehydrated(fn ($state) => filled($state)),
            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->dehydrated(false),
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email == 'admin@gmail.com';
    }
}
