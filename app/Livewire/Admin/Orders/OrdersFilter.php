<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\DeliveryMethodEnum;
use App\Enums\DeliveryStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Livewire\Forms\OrderFilterForm;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrdersFilter extends Component
{
    public OrderFilterForm $form;

    #[Computed()]
    public function tabs()
    {
        return OrderStatusEnum::cases();
    }

    #[Computed()]
    public function paymentMethods()
    {
        return PaymentMethodEnum::cases();
    }

    #[Computed()]
    public function deliveryMethods()
    {
        return DeliveryMethodEnum::cases();
    }

    #[Computed()]
    public function paymentStatuses()
    {
        return PaymentStatusEnum::cases();
    }

    #[Computed()]
    public function deliveryStatuses()
    {
        return DeliveryStatusEnum::cases();
    }

    public function updateTab($tab)
    {
        $this->form->orderStatus = $tab;
        $this->updateFilter();
    }

    public function updatedForm()
    {
        $this->updateFilter();
    }

    public function resetFilter()
    {
        $this->form->resetForm();
        $this->updateFilter();
    }

    private function updateFilter()
    {
        return $this->dispatch('set-filters', $this->form);
    }
    
    public function render()
    {
        return view('livewire.admin.orders.orders-filter');
    }
}
