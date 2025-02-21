<?php

namespace App\Livewire\Forms;

use App\Enums\OrderStatusEnum;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderFilterForm extends Form
{
    #[Url('status')]
    public ?string $orderStatus = OrderStatusEnum::NEW->value;
    public ?string $paymentMethod = null;
    public ?string $deliveryMethod = null;
    public ?string $paymentStatus = null;
    public ?string $deliveryStatus = null;
    public $startDate = null;
    public $endDate = null;
    public ?string $searchText = null;

    private array $defaultValues = [
        'orderStatus' => OrderStatusEnum::NEW->value,
        'paymentMethod' => null,
        'deliveryMethod' => null,
        'paymentStatus' => null,
        'deliveryStatus' => null,
        'startDate' => null,
        'endDate' => null,
        'searchText' => null,
    ];

    public function fillFromArray(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function resetForm()
    {
        foreach ($this->defaultValues as $key => $value) {
            $this->$key = $value;
        }
    }
}
