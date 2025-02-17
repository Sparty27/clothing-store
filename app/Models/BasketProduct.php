<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasketProduct extends Model
{
    use HasFactory;

    protected $table = 'basket_product';

    public $timestamps = true;

    protected $fillable = [
        'product_id', 
        'basket_id', 
        'size_id', 
        'count',
        'created_at',
        'updated_at',
    ];

    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function productSize()
    {
        return $this->hasOne(ProductSize::class, 'product_id', 'product_id')->where('size_id', $this->size_id);
    }
}
