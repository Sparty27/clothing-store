<?php

namespace App\Livewire\Site\Components;

use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductCard extends Component
{
    public $product;
    public $mainPhoto;
    public $isSmall = false;

    public function mount()
    {
        // $this->product->load('productSizes');
    }

    #[Computed()]
    public function productSizes()
    {
        return $this->product->productSizes;
    }
    
    // public function addToBasket(Product $product)
    // {
    //     if (basket()->addProduct($product)) {
    //         $this->dispatch('show-basket');
    //         // $this->dispatch('alert-open', "{$product->name} добавлено в кошику");
    //     } else {
    //         $this->dispatch('alert-open', "{$product->name} недоступна кількість");
    //     }

    //     $this->dispatch('updated-basket');
    // }

    // #[On('updated-basket')]
    // public function isInBasket(Product $product)
    // {
    //     return basket()->isInBasket($product);
    // }

    public function render()
    {
        return view('livewire.site.components.product-card');
    }
}
