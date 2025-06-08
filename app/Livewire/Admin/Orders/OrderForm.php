<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\DeliveryMethodEnum;
use App\Enums\DeliveryStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Rules\WarehouseBelongsToCity;
use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderForm extends Component
{
    public Order $order;
    public $selectedCity = null;
    public $selectedWarehouse = null;
    public array $data;
    public array $quantities = [];
    public array $prices = [];

    public function mount(Order $order)
    {
        $this->order = $order;

        foreach ($this->orderProducts as $orderProduct) {
            $this->quantities[$orderProduct->id] = $orderProduct->count;
            $this->prices[$orderProduct->id] = number_format($orderProduct->price->getAmount()->toFloat(), 2, '.', '');
        }

        if ($order) {

            // if ($order->status !== OrderStatusEnum::PROCESS) {
            //     return redirect()->route('admin.orders.index')->with('alert', 'Редагування можливе тільки для замовлень в обробці');
            // }

            $this->data['warehouse_id'] = $order->warehouse_id;
            $this->data['status'] = $order->status;
            $this->data['total'] = $order->total->getAmount()->toFloat();
            $this->data['phone'] = $order->phone->formatInternational();
            $this->data['customer_name'] = $order->customer_name;
            $this->data['customer_last_name'] = $order->customer_last_name;
            $this->data['payment_method'] = $order->payment_method;
            $this->data['payment_status'] = $order->payment_status;
            $this->data['delivery_method'] = $order->delivery_method;
            $this->data['delivery_status'] = $order->delivery_status;
            $this->data['ttn'] = $order->ttn;
            $this->data['note'] = $order->note;

            if ($order->delivery_method === DeliveryMethodEnum::NOVAPOSHTA) {
                $this->selectedCity = $order?->warehouse?->city->id ?? null;
                $this->selectedWarehouse = $order?->warehouse_id ?? null;
            }
        }
    }

    #[Computed()]
    public function orderProducts()
    {
        return $this->order->orderProducts()->with('product', 'product.mainPhoto')->get();
    }

    #[Computed()]
    public function pricesTotal()
    {
        try {
            $total = 0;

            foreach ($this->orderProducts as $orderProduct) {
                $total += Money::of($this->prices[$orderProduct->id], 'UAH', roundingMode: RoundingMode::DOWN)
                    ->multipliedBy($this->quantities[$orderProduct->id])
                    ->getAmount()
                    ->toFloat();
            }

            return number_format($total, 2);
        } catch (Exception $e) {
            return 'Помилка';
        }
    }

    public function updatedQuantities($value, $key)
    {
        $orderProduct = OrderProduct::find($key);

        $maxCount = $orderProduct->count + $orderProduct->productSize->count;

        $this->validateOnly("quantities.$key", [
            "quantities.$key" => "required|integer|min:1|max:{$maxCount}",
        ], [], [
            "quantities.$key" => 'Кількість'
        ]);
    }

    public function updatedPrices($value, $key)
    {
        $this->validateOnly("prices.$key", [
            "prices.$key" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:1",
        ], [], [
            "prices.$key" => 'Ціна'
        ]);
    }

    public function isPriceEqual(OrderProduct $orderProduct)
    {
        $orderProductPrice = number_format((float) $orderProduct->price->getAmount()->toFloat(), 2, '.', '');

        return $orderProductPrice === $this->prices[$orderProduct->id];
    }

    public function restoreOrderProduct(OrderProduct $orderProduct, $type)
    {
        switch ($type) {
            case 'quantity':
                $this->quantities[$orderProduct->id] = $orderProduct->count;
                break;
            case 'price':
                $this->prices[$orderProduct->id] = number_format($orderProduct->price->getAmount()->toFloat(), 2, '.', '');
                break;

        }
    }

    public function rules()
    {
        $rules = [
            'data.customer_name' => 'required|string|min:3|max:191',
            'data.customer_last_name' => 'required|string|min:3|max:191',
            'data.phone' => 'required|string|min:8|phone:UA',
            'data.note' => 'nullable|string|max:9999',
            'data.delivery_method' => [Rule::enum(DeliveryMethodEnum::class)],
            'data.payment_method' => [Rule::enum(PaymentMethodEnum::class)],
            'data.delivery_status' => [Rule::enum(DeliveryStatusEnum::class)],
            'data.payment_status' => [Rule::enum(PaymentStatusEnum::class)],
            'data.ttn' => 'nullable|string|max:17',
        ];

        if ($this->data['delivery_method'] === DeliveryMethodEnum::NOVAPOSHTA) {
            $rules['selectedCity'] = ['required', 'exists:cities,id'];
            $rules['selectedWarehouse'] = ['required', new WarehouseBelongsToCity($this->selectedCity),];
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'data.customer_name' => 'Імʼя',
            'data.customer_last_name' => 'Прізвище',
            'data.phone' => 'Телефон',
            'data.note' => 'Примітка',
            'data.delivery_method' => 'Спосіб доставки',
            'data.payment_method' => 'Спосіб оплати',
        ];
    }

    private function validateBeforeSave(): bool
    {
        $this->resetErrorBag();

        foreach ($this->orderProducts as $orderProduct) {
            $key = $orderProduct->id;
            $maxCount = $orderProduct->count + $orderProduct->productSize->count;

            try {
                $this->validateOnly("quantities.$key", [
                    "quantities.$key" => "required|integer|min:1|max:{$maxCount}",
                ], [], [
                    "quantities.$key" => 'Кількість'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->setErrorBag($e->validator->errors());
            }

            try {
                $this->validateOnly("prices.$key", [
                    "prices.$key" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:1",
                ], [], [
                    "prices.$key" => 'Ціна'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->setErrorBag($e->validator->errors());
            }
        }

        return !$this->getErrorBag()->isNotEmpty();
    }

    private function updateProducts()
    {
        foreach ($this->orderProducts as $orderProduct) {
            $countDiff = $this->quantities[$orderProduct->id] - $orderProduct->count;

            if ($countDiff !== 0) {
                $orderProduct->productSize->count = $orderProduct->productSize->count - $countDiff;
                $orderProduct->productSize->save();
            }

            $orderProduct->count = $this->quantities[$orderProduct->id];
            $orderProduct->price = Money::of($this->prices[$orderProduct->id], 'UAH', roundingMode: RoundingMode::DOWN);
            $orderProduct->save();
        }
    }

    public function save()
    {
        if (!$this->validateBeforeSave()) {
            return;
        }

        $validated = $this->validate();

        $data = $validated['data'];

        if ($data['delivery_method'] === DeliveryMethodEnum::NOVAPOSHTA) {
            $data['warehouse_id'] = $validated['selectedWarehouse'];
        }

        $data['total'] = Money::of(str_replace(',', '', $this->pricesTotal()), 'UAH', roundingMode: RoundingMode::DOWN);
        $this->order->update($data);
        $this->updateProducts();

        $this->dispatch('alert-open', "Замовлення {$this->order->id} оновлено");
    }

    public function render()
    {
        return view('livewire.admin.orders.order-form');
    }
}
