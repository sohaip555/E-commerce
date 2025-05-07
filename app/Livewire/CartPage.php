<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Component;

class CartPage extends Component
{
    public $cart_items;
    public $grand_amount = 0;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_amount = CartManagement::calculateGrandTotal($this->cart_items);

    }
    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->grand_amount = CartManagement::calculateGrandTotal($this->cart_items);

        $this->dispatch('updated-cart-count',  total_items: count($this->cart_items))->to(Navbar::class);

    }

    public function increase($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItems($product_id);
        $this->grand_amount = CartManagement::calculateGrandTotal($this->cart_items);

    }

    public function decrease($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItems($product_id);
        $this->grand_amount = CartManagement::calculateGrandTotal($this->cart_items);

//        dd(CartManagement::calculateGrandTotal($this->cart_items));

    }

    public function checkout()
    {
        return redirect('/checkout');
    }
    public function render()
    {

//        dd($this->cart_items);
        return view('livewire.cart-page',
            [
                'cart_items' => $this->cart_items,
            ]);
    }
}
