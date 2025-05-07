<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class MyOrderDetailPage extends Component
{

    public $order;
    public $order_items;
    public $address;

    public function mount( Order $order)
    {

        $this->order = $order;
        $this->order_items = $order->orderItems;
        $this->address = $order->address;
//        dd($order, $this->order_items, $order->address->created_at);

    }

    public function render(order $order)
    {
        return view('livewire.my-order-detail-page',[
            'order' => $this->order,
            'order_items' => $this->order_items,
            'address' => $this->address,
        ]);
    }
}
