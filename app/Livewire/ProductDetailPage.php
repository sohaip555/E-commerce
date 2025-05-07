<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public $product;
    public $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function increase()
    {
        $this->quantity++;
    }

    public function decrease()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id)
    {

        $total_items = CartManagement::addItemToCart($product_id);
        $this->dispatch('updated-cart-count',  total_items: $total_items)->to(Navbar::class);

        LivewireAlert::title('Success')
            ->text('product added successfully')
            ->position('bottom-end')
            ->timer(2900)
            ->show();
    }
    public function render()
    {
//        dd($this->product);

        return view('livewire.product-detail-page',
            [
                'product' => $this->product,
            ]);
    }
}
