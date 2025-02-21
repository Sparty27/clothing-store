<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatusEnum;
use App\Livewire\Forms\OrderFilterForm;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTable extends Component
{
    use WithPagination;

    public OrderFilterForm $filter;
    public $sortColumn = 'order_date';
    public $sortDirection = 'desc';

    public function mount()
    {
        // $this->filter->orderStatus = OrderStatusEnum::NEW->value;
    }

    protected $mapping = [
        'order_date' => 'created_at',
    ];

    #[On('set-filters')]
    public function setFilters($data) 
    {
        $this->filter->fillFromArray($data);

        $this->resetPage();
    }

    #[Computed()]
    #[On('updated-orders-table')]
    public function orders()
    {
        $builder = Order::query();

        $this->searchQuery($builder);
        $this->filterQuery($builder);
        $this->sortQuery($builder);

        return $builder->paginate(20);
    }

    public function sortQuery(Builder $builder)
    {
        $builder->when($this->sortColumn, function (Builder $query) {
            if (!$this->sortColumn || !$this->sortDirection) {
                return;
            }

            $query->orderBy($this->mapping[$this->sortColumn], $this->sortDirection);
        });
    }

    public function searchQuery(Builder $builder)
    {
        $builder->when($this->filter->searchText, function (Builder $query, $text) {
            $query->where(function (Builder $subQuery) use ($text) {
                $subQuery->where('customer_name', 'like', "%$text%")
                         ->orWhere('customer_last_name', 'like', "%$text%")
                         ->orWhere('phone', 'like', "%$text%");
            });
        });
    }

    public function filterQuery(Builder $builder)
    {
        $this->filterSelectQuery($builder, 'status', $this->filter->orderStatus);
        $this->filterSelectQuery($builder, 'payment_method', $this->filter->paymentMethod);
        $this->filterSelectQuery($builder, 'delivery_method', $this->filter->deliveryMethod);
        $this->filterSelectQuery($builder, 'payment_status', $this->filter->paymentStatus);
        $this->filterSelectQuery($builder, 'delivery_status', $this->filter->deliveryStatus);

        $builder->when($this->filter->startDate, function ($builder, $date) {
            $builder->where('created_at', '>=', $date);
        });
        $builder->when($this->filter->endDate, function ($builder, $date) {
            $builder->where('created_at', '<', Carbon::parse($date)->addDay());
        });
    }

    private function filterSelectQuery(Builder $builder, $column, $filterOption)
    {
        $builder->when($filterOption && $filterOption !== 'all', function (Builder $query) use ($column, $filterOption) {
            $query->where($column, $filterOption);
        });
    }

    private function checkProductsExist($orderProducts): bool
    {
        $isDeletedProducts = false;

        foreach ($orderProducts as $orderProduct) {
            if (!$orderProduct->product->exists()) {
                $message = "Товар \"".$orderProduct->name."\" не існує, потрібна кількість ".$orderProduct->count;

                Log::warning($message);
                $this->dispatch('alert-open', $message);

                $isDeletedProducts = true;
            }
        }

        if ($isDeletedProducts) {
            return false;
        }

        return true;
    }

    private function checkProductsAvailable($orderProducts): bool
    {
        $isProductsAvailable = true;

        foreach ($orderProducts as $orderProduct) {
            if ($orderProduct->productSize->count < $orderProduct->count) {
                $message = "Товар \"".$orderProduct->name."\" не хватає на складі, потрібна кількість ".$orderProduct->count;

                Log::warning($message);
                $this->dispatch('alert-open', $message);

                $isProductsAvailable = false;
            }
        }

        return $isProductsAvailable;
    }

    public function updateOrderStatus(Order $order, OrderStatusEnum $status)
    {
        $beforeStatus = $order->status;
        $orderProducts = $order->orderProducts;

        if ($order->status === $status) {
            return;
        }

        if (OrderStatusEnum::isNeededStoreProducts($beforeStatus, $status)) {
            if (!$this->checkProductsExist($orderProducts)) {
                return;
            }

            foreach ($orderProducts as $orderProduct) {
                $orderProduct->productSize->increment('count', $orderProduct->count);
            }

        } elseif (OrderStatusEnum::isNeededGetProducts($beforeStatus, $status)) {
            if (!$this->checkProductsExist($orderProducts)) {
                return;
            }

            if (!$this->checkProductsAvailable($orderProducts)) {
                return;
            }

            foreach ($orderProducts as $orderProduct) {
                $orderProduct->productSize->decrement('count', $orderProduct->count);
            }
        }

        $order->status = $status;
        $order->save();

        $this->dispatch('alert-open', "ID {$order->id} Статус замовлення було змінено");
    }

    public function toggleSortColumn($column)
    {
        if ($column === $this->sortColumn) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->sortColumn = $column;
        $this->sortDirection = 'asc';
    }

    public function copy($elementId)
    {
        $this->dispatch('copyToClipboard', $elementId);
        $this->dispatch('alert-open', 'Скопійовано ТТН');
    }
    
    public function render()
    {
        return view('livewire.admin.orders.orders-table');
    }
}
