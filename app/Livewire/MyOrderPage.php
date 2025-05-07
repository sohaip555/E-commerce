<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class MyOrderPage extends Component
{

    public function render()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
//        dd($orders);

        return view('livewire.my-order-page',[
            'orders' => $orders
        ]);
    }
}
