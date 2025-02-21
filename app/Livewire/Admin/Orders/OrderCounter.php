<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderCounter extends Component
{
    #[Computed()]
    public function count()
    {
        return Order::where('status', OrderStatusEnum::NEW)->count();
    }
    
    public function render()
    {
        return view('livewire.admin.orders.order-counter');
    }
}
