<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductSize extends Model
{
    use HasFactory;

    public $table = 'product_size';

    protected $fillable = [
        'product_id',
        'size_id',
        'count',
    ];

    public function size(): HasOne
    {
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
}
