<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $total_items;

    public function mount()
    {
        $this->total_items = count(CartManagement::getCartItemsFromCookie());
    }

    #[On('updated-cart-count')]
    public function updateCartCount($total_items): void
    {
        $this->total_items = $total_items;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
