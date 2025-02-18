<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';

    public $timestamps = true;

    protected $fillable = [
        'order_id', 
        'product_id', 
        'name',
        'count',
        'price',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function moneyPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return number_format($this->price->getAmount()->toFloat(), 2, '.', '');
            },
        );
    }
}
