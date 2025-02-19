<?php

namespace App\Livewire\Site;

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

class MyOrders extends Component
{
    public $ordersCount = 5;
    public $showAll = false;
    
    #[Computed()]
    public function orders()
    {
        $query = Order::where('user_id', auth()->user()->id)
            ->orderByDesc('created_at')
            ->with('orderProducts', 'orderProducts.product', 'orderProducts.product.mainPhoto');

        if (!$this->showAll) {
            $query->limit(5);
        }

        return $query->get();
    }

    public function repeatOrder(Order $order)
    {
        $orderProducts = $order->orderProducts;

        foreach ($orderProducts as $orderProduct) {
            $product = $orderProduct->product;
            $productSize = $orderProduct->productSize;

            if ($product->is_active == false || $productSize->count <= 0) {
                $this->addError("products.{$orderProduct->id}.available", 'Товар недоступний');
            } else if ($orderProduct->count > $productSize->count) {
                $this->addError("products.{$orderProduct->id}.status", 'Недоступна кількість товару');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            $this->dispatch('alert-open', "У замовленні є недоступні товари");

            return;
        }

        basket()->clear();

        foreach ($orderProducts as $orderProduct) {
            basket()->getbasket()->basketProducts()->create([
                'product_id' => $orderProduct->product_id,
                'size_id' => $orderProduct->size_id,
                'count' => $orderProduct->count,
            ]);
        }

        return redirect()->route('orders.checkout', ['order' => $order->id]);
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }
    
    public function render()
    {
        return view('livewire.site.my-orders');
    }
}
