<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductsPage extends Component
{
    #[Url]
    public $categories_selected = [];

    #[Url]
    public $brands_selected = [];

    public $featured_product;
    public $on_sale;
    public $price_range = 300000;

    public $sort_by;


    public function addToCart($product_id)
    {

        $total_items = CartManagement::addItemToCart($product_id);
//        dd($total_items);
        $this->dispatch('updated-cart-count',  total_items: $total_items)->to(Navbar::class);

            LivewireAlert::title('Success')
            ->text('product added successfully')
            ->position('bottom-end')
            ->timer(2900)
            ->show();
    }

    public function render()
    {
        $query = Product::where('is_active', true);

        if (!empty($this->categories_selected)) {
            $query->whereIn('category_id', $this->categories_selected);
        }

        if (!empty($this->brands_selected)) {
            $query->whereIn('brand_id', $this->brands_selected);
        }

        if ($this->featured_product) {
            $query->where('is_feature', true);
        }

        if ($this->on_sale) {
            $query->where('on_sale', true);
        }

        if ($this->price_range) {
            $query->where('price', '<=', $this->price_range);
        }

        switch ($this->sort_by) {
            case 'latest':
                $query->latest();
                break;
            case 'Price':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        return view('livewire.products-page',
            [
                'products' => $query->paginate(9),
                'categories' => Category::where('is_active', true)->get(),
                'brands' => Brand::where('is_active', true)->get(),
            ]);
    }
}
