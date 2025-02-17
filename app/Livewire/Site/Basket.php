<?php

namespace App\Livewire\Site;

use App\Models\BasketProduct;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Basket extends Component
{
    #[Computed()]
    #[On('updated-basket')]
    public function basketProducts()
    {
        $basketProducts = basket()->getBasket()->basketProducts()->with('product', 'productSize', 'size')->get();

        return $basketProducts;
    }

    #[Computed()]
    public function basketProductsCount()
    {
        return basket()->getBasket()->basketProducts()->count();
    }

    #[Computed()]
    #[On('updated-basket')]
    public function total()
    {
        $basketProducts = $this->basketProducts;

        $total = 0;

        foreach ($basketProducts as $basketProduct) {
            $total += $basketProduct->product->price->multipliedBy($basketProduct->count)->getAmount()->toFloat();
        }

        return $total;
    }

    public function increment(BasketProduct $product)
    {
        $isSuccess = basket()->changeProductCount($product, 1);

        if (!$isSuccess) {
            $this->dispatch('alert-open', "Недоступна кількість товару {$product->name}");
        }

        $this->dispatch('updated-basket-product-count');
    }

    public function decrement(BasketProduct $product)
    {
        if (($product->count - 1) <= 0) {
            return;
        }
        
        basket()->changeProductCount($product, -1);

        $this->dispatch('updated-basket-product-count');
    }

    #[On('remove-from-basket')]
    public function remove($basketProductId)
    {
        $basketProduct = BasketProduct::find($basketProductId);

        if ($basketProduct == null) {
            return;
        }

        basket()->removeProduct($basketProduct);

        $this->dispatch('updated-basket');
        $this->dispatch('alert-open', 'Товар видалено з кошика');
    }

    public function makeOrder() 
    {
        $this->resetErrorBag();

        foreach ($this->basketProducts as $basketProduct) {
            $product = $basketProduct->product;

            if ($product->is_active == false || $product->count <= 0) {
                basket()->removeProduct($basketProduct);

                $this->dispatch('alert-open', "Товар {$product->name} недоступний.");

                $this->addError("products.{$basketProduct->id}.available", 'Товар недоступний');
            } else if ($basketProduct->count > $product->count) {
                $basketProduct->count = 1;
                $basketProduct->save();
    
                $this->dispatch('alert-open', "Недоступна кількість товара {$product->name}.");
    
                $this->addError("products.{$basketProduct->id}.status", 'Недоступна кількість товару');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            $this->dispatch('updated-basket');

            return;
        }

        return redirect()->route('orders.checkout');
    }
    
    public function render()
    {
        return view('livewire.site.basket');
    }
}
