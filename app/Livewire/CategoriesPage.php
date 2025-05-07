<?php

namespace App\Livewire;

use Livewire\Component;

class CategoriesPage extends Component
{
    public function render()
    {
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('livewire.categories-page', [
            'categories' => $categories,
        ]);
    }
}
