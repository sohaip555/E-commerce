<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 'new';
        $data['grand_total'] = 0;
        $data['currency'] = 'USD';
        $data['payment_status'] = 'pending';
        return $data;
    }
}
