<?php

namespace App\Livewire\Site;

use App\Enums\DeliveryMethodEnum;
use App\Enums\DeliveryStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\Payment\MonobankService;
use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

class Checkout extends Component
{
    public $name;
    public $lastName;
    public $phone;
    public $note;
    public $deliveryMethod = DeliveryMethodEnum::NOVAPOSHTA->value;
    public $paymentMethod = PaymentMethodEnum::MONOBANK->value;
    public $selectedCity = null;
    public $selectedWarehouse = null;

    #[Url('order')]
    public $order;

    public function mount()
    {
        // $this->poshtaForm->setData();

        $user = auth()->user();

        if (!$user) {
            return;
        }

        $this->name = $user->name;
        $this->lastName = $user->last_name;
        $this->phone = $user->phone->formatInternational();

        if (!$this->order) {
            return;
        }

        $order = Order::where('id', $this->order)->where('user_id', $user->id)->with('warehouse', 'warehouse.city')->first();

        if (!$order) {
            return;
        }

        $this->name = $order->customer_name;
        $this->lastName = $order->customer_last_name;
        $this->phone = $order->phone->formatInternational();
        $this->deliveryMethod = $order->delivery_method->value;
        $this->paymentMethod = $order->payment_method->value;
        $this->note = $order->note;

        if ($order->delivery_method === DeliveryMethodEnum::NOVAPOSHTA) {
            $this->selectedCity = $order->warehouse->city->id;
            $this->selectedWarehouse = $order->warehouse_id;
        }
    }

    #[Computed()]
    #[On('updated-basket')]
    #[On('updated-basket-product-count')]
    public function basketProducts()
    {
        return basket()->getBasket()->basketProducts()->with('product', 'product.mainPhoto')->get();
    }

    #[Computed()]
    #[On('updated-basket')]
    #[On('updated-basket-product-count')]
    public function totalOldPrice()
    {
        $total = 0;

        foreach ($this->basketProducts as $basketProduct) {
            $product = $basketProduct->product;

            if ($product->old_price === null) {
                $price = $product->price;
            } else {
                $price = $product->old_price;
            }

            $total += $price->multipliedBy($basketProduct->count)->getAmount()->toFloat();
        }

        return $total;
    }

    #[Computed()]
    #[On('updated-basket')]
    #[On('updated-basket-product-count')]
    public function total()
    {
        $total = 0;

        foreach ($this->basketProducts as $basketProduct) {
            $total += $basketProduct->product->price->multipliedBy($basketProduct->count)->getAmount()->toFloat();
        }

        return $total;
    }

    // public function updatedPoshtaFormSearchCity($value)
    // {
    //     $this->poshtaForm->cities = $this->poshtaForm->searchCities();

    //     $this->dispatch('updateChoices', options: $this->poshtaForm->cities, id: 'city-selector');
    // }

    // public function updatedPoshtaFormSearchWarehouse($value)
    // {
    //     $this->poshtaForm->warehouses = $this->poshtaForm->searchWarehouses();

    //     $this->dispatch('updateChoices', options: $this->poshtaForm->warehouses, id: 'warehouse-selector');
    // }

    // public function updatedPoshtaFormSelectedCity($value)
    // {
    //     $this->poshtaForm->selectedWarehouse = null;
    //     $this->poshtaForm->searchWarehouse = '';
    //     $this->poshtaForm->warehouses = $this->poshtaForm->searchWarehouses();

    //     if (!empty($this->poshtaForm->warehouses)) {
    //         $this->poshtaForm->warehouses[0]['selected'] = true;
    //         $this->poshtaForm->selectedWarehouse = $this->poshtaForm->warehouses[0]['value'];
    //     }

    //     $this->dispatch('resetChoices', options: $this->poshtaForm->warehouses, id: 'warehouse-selector');
    // }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:3|max:191',
            'lastName' => 'required|string|min:3|max:191',
            'phone' => 'required|string|min:8|phone:UA',
            'note' => 'nullable|string|max:9999',
            'deliveryMethod' => [Rule::enum(DeliveryMethodEnum::class)],
            'paymentMethod' => [Rule::enum(PaymentMethodEnum::class)],
        ];

        if ($this->deliveryMethod === DeliveryMethodEnum::NOVAPOSHTA->value) {
            $rules['selectedCity'] = 'required|exists:cities,id';
            $rules['selectedWarehouse'] = 'required|exists:warehouses,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'selectedCity.required' => 'Виберіть місто',
            'selectedWarehouse.required' => 'Виберіть відділення',
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'Імʼя',
            'selectedCity' => 'Місто',
            'selectedWarehouse' => 'Відділення',
        ];
    }

    public function save(OrderService $orderService, MonobankService $monobankService)
    {
        $this->validateBeforeOrder();

        $validated = $this->validate();

        $data = [
            'warehouse_id' => $validated['selectedWarehouse'] ?? null,
            'user_id' => auth()->user()?->id,
            'status' => OrderStatusEnum::NEW,
            'total' => Money::of($this->total, 'UAH', roundingMode: RoundingMode::DOWN),
            'phone' => (new PhoneNumber($validated['phone'], 'UA'))->formatE164(),
            'customer_name' => $validated['name'],
            'customer_last_name' => $validated['lastName'],
            'payment_method' => PaymentMethodEnum::tryFrom($validated['paymentMethod']),
            'payment_status' => PaymentStatusEnum::CREATED,
            'delivery_method' => DeliveryMethodEnum::tryFrom($validated['deliveryMethod']),
            'delivery_status' => DeliveryStatusEnum::CREATED,
            'note' => $validated['note']
        ];

        $products = [];
        foreach ($this->basketProducts as $basketProduct) {
            $products[] = [
                'product_id' => $basketProduct->product_id,
                'size_id' => $basketProduct->productSize->size_id,
                'name' => $basketProduct->product->name,
                'count' => $basketProduct->count,
                'price' => $basketProduct->product->price,
            ];
        }

        try {
            $order = $orderService->checkout($data, $products);

            switch($data['payment_method'])
            {
                case PaymentMethodEnum::MONOBANK:
                    $url = $monobankService->checkout($order);
                    break;
                default:
                    $url = route('orders.thank');
                    break;
            }

            return redirect($url);

        } catch (Exception $e) {
            Log::error('Помилка зі створенням замовлення, (Checkout->save): '.$e->getMessage());
            
            return redirect()->route('index')->with('alert', 'Проблема з оформленням замовлення');
        }
    }

    private function validateBeforeOrder()
    {
        $this->resetErrorBag();

        if ($this->basketProducts->isEmpty()) {
            return redirect()->route('index')->with('alert', 'Кошик пустий');
        }

        foreach ($this->basketProducts as $basketProduct) {
            $product = $basketProduct->product;
            $productSize = $basketProduct->productSize()->first();

            if ($product->is_active == false || $productSize->count <= 0) {
                basket()->removeProduct($basketProduct);

                $this->dispatch('alert-open', "Товар {$product->name} недоступний.");

                $this->addError("products.{$basketProduct->id}.available", 'Товар недоступний');
            } elseif ($basketProduct->count > $productSize->count) {
                $basketProduct->count = 1;
                $basketProduct->save();
    
                $this->dispatch('alert-open', "Недоступна кількість товару {$product->name}.");
    
                $this->addError("products.{$basketProduct->id}.status", 'Недоступна кількість товару');
            }
        }

        if ($this->getErrorBag()->isNotEmpty()) {
            if (basket()->getBasketProducts()->isEmpty()) {
                return redirect()->route('index')->with('alert', 'Кошик пустий через те, що всі товари були недоступними');
            }

            $this->dispatch('updated-basket');
            return;
        }
    }
    
    public function render()
    {
        return view('livewire.site.checkout');
    }
}
