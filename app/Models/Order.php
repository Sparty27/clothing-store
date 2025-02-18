<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\DeliveryMethodEnum;
use App\Enums\DeliveryStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'warehouse_id',
        'total',
        'status',
        'phone',
        'customer_name',
        'customer_last_name',
        'payment_method',
        'payment_status',
        'transaction_id',
        'transaction_modified_at',
        'delivery_method',
        'delivery_status',
        'ttn',
        'note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total' => MoneyCast::class,
        'status' => OrderStatusEnum::class,
        'phone' => E164PhoneNumberCast::class.':UA',
        'payment_method' => PaymentMethodEnum::class,
        'payment_status' => PaymentStatusEnum::class,
        'delivery_method' => DeliveryMethodEnum::class,
        'delivery_status' => DeliveryStatusEnum::class,
        'transaction_modified_at' => 'datetime',
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class)
    //         ->withPivot('name', 'count', 'price', 'sum')
    //         ->withTimestamps();
    // }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function scopeNotCompleted(Builder $query)
    {
        return $query->whereNotIn('payment_status', [PaymentStatusEnum::FAILED, PaymentStatusEnum::SUCCESS]);
    }

    public function scopeShouldCheck(Builder $query)
    {
        return $query->notCompleted()->whereNotNull('transaction_id');
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->created_at)->format('d.m.Y');
            },
        );
    }

    protected function formattedDateTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
            },
        );
    }

    protected function moneyTotal(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return number_format($this->total->getAmount()->toFloat(), 2, '.', ' ');
            },
        );
    }
}
